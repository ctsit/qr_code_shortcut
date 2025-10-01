# QR Code Shortcut - ARCHIVED

**This repository has been archived and is no longer actively maintained.**

This project was archived as of October 1, 2025. The project for which it was written is now over. There's no funding to provide further maintenance for other projects. Please don't hesitate to use this code in accordance with the license; however, the authors are unable to offer any additional support.

-----------

This is a REDCap external module that provides a shortcut to generate a survey QR code for a new data entry.

This module provides a survey kickstart button to be used when the form needs to be presented to the applicants as a QR code. The button wraps the following steps into one single procedure:

1. Save new record's first form
1. Handle eventual warnings about required fields
1. Click on survey options
1. Select Survey Access Code and QR Code
1. Get QR code

## Prerequisites
- REDCap >= 8.0.3

## Installation
- Clone this repo into `<redcap-root>/modules/qr_code_shortcut_<version_number>`.
- Go to **Control Center > Manage External Modules** and enable QR Code Shortcut.
- Go to your project home page, click on **Manage External Modules** link, and then enable QR Code Shortcut.

## Configuration
This module does not require further configuration - just make sure that surveys are enabled for your project.

## How to use it
Once you add a new record, you might see the **Generate Survey QR Code** button as follows:

![Generate QR code button](img/qr_code_button.png)

Click on the button to see the survey QR code right away on your screen. Obs.: this operation will save your form.

![QR code image](img/qr_code_image.png)

For existing records, a "Display Survey QR Code" button is displayed, which shows up the QR code (without submitting/saving the form).

![Generate QR code button](img/qr_code_button2.png)
