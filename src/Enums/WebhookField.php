<?php namespace OnChainPay\Enums;

enum WebhookField : string
{
    case Id = 'id';
    case Event = 'event';
    case EventId = 'eventId';
    case RequestUrl = 'requestUrl';
    case RequestHeaders = 'requestHeaders';
    case RequestBody = 'requestBody';
    case ResponseCode = 'responseCode';
    case ResponseStatus = 'responseStatus';
    case ResponseBody = 'responseBody';
    case SentAt = 'sentAt';
    case Signature = 'signature';
    case ApiKey = 'apiKey';
    case ApiKeyAlias = 'apiKeyAlias';
    case CreatedAt = 'createdAt';
    case UpdatedAt = 'updatedAt';
}
