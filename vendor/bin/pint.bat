@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/pint
SET COMPOSER_RUNTIME_BIN_DIR=%~dp0
php "%BIN_TARGET%" %*
