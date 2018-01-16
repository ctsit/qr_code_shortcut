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

        if (empty($_GET['__qrcode'])) {
            if (!empty($record)) {
                return;
            }

            // Setting up button to generate QR code.
            $msg = urlencode('The survey QR code has been generated successfully.');
            $settings = array(
                'submitPath' => APP_PATH_WEBROOT . 'DataEntry/index.php?pid=' . $project_id . '&id=' . getAutoId() . '&event_id=' . $event_id . '&page=' . $instrument . '&__qrcode=1&auto=1&__msg=' . $msg,
                'buttonContents' => '<button class="btn btn-success" id="submit-btn-qrcode" name="submit-btn-qrcode" onclick="qrCodeShortcut.generateQRCode();">Generate Survey QR Code</button>',
            );
        }
        elseif (!empty($record)) {
            // Displaying QR code.
            list(, $hash) = Survey::getFollowupSurveyParticipantIdHash($Proj->forms[$instrument]['survey_id'], $record, $event_id, false, $instance);
            $settings = array(
                'imageContents' => '<img class="qr-code" src="' . APP_PATH_WEBROOT . 'Surveys/survey_link_qrcode.php?pid=' . $project_id . '&hash=' . $hash . '">',
            );

            if (isset($_GET['__msg'])) {
                // Showing success message.
                echo '<div class="darkgreen qr-code-msg"><img src="' . APP_PATH_IMAGES . 'tick.png"> ' . htmlspecialchars($_GET['__msg']) . '</div>';
            }

            $this->includeCss('css/qr-code-shortcut.css');
        }
        else {
            return;
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
