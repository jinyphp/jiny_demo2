@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../jiny/lamp/lamp
php "%BIN_TARGET%" %*
