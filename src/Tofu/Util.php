<?php
function notice($strMessage) {
    trigger_error($strMessage, E_USER_NOTICE);
}
function warning($strMessage) {
    trigger_error($strMessage, E_USER_WARNING);
}
function error($strMessage) {
    trigger_error($strMessage, E_USER_ERROR);
}
