<?php
/**
 * @file
 * Provides ExternalModule class for QR Code Shortcut.
 */

namespace QRCodeShortcut\ExternalModule;

use ExternalModules\AbstractExternalModule;
use ExternalModules\ExternalModules;
use Survey;

/**
 * ExternalModule class for QR Code Shortcut.
 */
class ExternalModule extends AbstractExternalModule {

    /**
     * @inheritdoc.
     */
    function redcap_data_entry_form_top($project_id, $record, $instrument, $event_id, $group_id) {
        global $Proj, $surveys_enabled;

        if (!$surveys_enabled || !isset($Proj->forms[$instrument]['survey_id'])) {
            return;
        }

        $settings = array();

        if (empty($_GET['__show_qr_code'])) {
            if (empty($record)) {
                $title = 'Generate Survey QR Code';
                $op = 'generate';

                $args = array(
                    'pid' => $project_id,
                    'id' => getAutoId(),
                    'page' => $instrument,
                    'event_id' => $event_id,
                    'auto' => 1,
                    '__show_qr_code' => 1,
                    '__msg' => 'The survey QR code has been generated successfully.',
                );

                $settings['redirectPath'] = APP_PATH_WEBROOT . 'DataEntry/index.php?' . http_build_query($args);
            }
            else {
                $title = 'Display Survey QR Code';
                $op = 'display';
            }

            // Setting up button to generate QR code.
            $settings['buttonContents'] = '<button class="btn btn-success" id="submit-btn-qrcode" name="submit-btn-qrcode" onclick="qrCodeShortcut.' . $op . 'QRCode();">' . $title . '</button>';
        }

        if (!empty($record)) {
            // Displaying QR code.
            list(, $hash) = Survey::getFollowupSurveyParticipantIdHash($Proj->forms[$instrument]['survey_id'], $record, $event_id, false, $instance);

            $extra_classes = empty($_GET['__show_qr_code']) ? ' qr-code-hidden' : '';
            $settings['imageContents'] = '<img class="qr-code' . $extra_classes . '" src="' . APP_PATH_WEBROOT . 'Surveys/survey_link_qrcode.php?pid=' . $project_id . '&hash=' . $hash . '">';

            if (isset($_GET['__msg'])) {
                // Showing success message.
                echo '<div class="darkgreen qr-code-msg"><img src="' . APP_PATH_IMAGES . 'tick.png"> ' . htmlspecialchars($_GET['__msg']) . '</div>';
            }

            $this->includeCss('css/qr-code-shortcut.css');
        }

        $this->setJsSetting('qrCodeShortcut', $settings);
        $this->includeJs('js/qr-code-shortcut.js');
    }

    /**
     * Includes a local CSS file.
     *
     * @param string $path
     *   The relative path to the css file.
     */
    protected function includeCss($path) {
        echo '<link rel="stylesheet" href="' . $this->getUrl($path) . '">';
    }

    /**
     * Includes a local JS file.
     *
     * @param string $path
     *   The relative path to the js file.
     */
    protected function includeJs($path) {
        echo '<script src="' . $this->getUrl($path) . '"></script>';
    }

    /**
     * Sets a JS setting.
     *
     * @param string $key
     *   The JS setting key.
     * @param mixed $value
     *   The JS setting value.
     */
    protected function setJsSetting($key, $value) {
        echo '<script>' . $key . ' = ' . json_encode($value) . ';</script>';
    }
}
