<?php

Broadcast::channel('team.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('users.online', function ($user) {
    return true;
});

Broadcast::channel('document.{documentId}', function ($user, $documentId) {
    return $user->hasAccessToDocument($documentId);
});

Broadcast::channel('autosave.{documentId}', function ($user, $documentId) {
    return $user->hasAccessToDocument($documentId);
});

Broadcast::channel('history.{documentId}', function ($user, $documentId) {
    return $user->hasAccessToDocument($documentId);
});
