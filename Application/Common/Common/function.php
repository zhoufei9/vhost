<?php
function getUserInfo() {
    return session('userInfo');
}

function getUid() {
    return session('userInfo.id');
}