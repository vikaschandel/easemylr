<?php
namespace App\Handler;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;

class CustomSignatureValidator implements SignatureValidator{
    public function isValid(Request $request, WebhookConfig $config): bool{
        $signature = $request->header($config->signatureHeaderName);
        if (! $signature) {
        return false;
            }
        $signingSecret = $config->signingSecret;
        if (empty($signingSecret)) {
        throw WebhookFailed::signingSecretNotSet();
            }
        $computedSignature = hash_hmac('sha512', $request->getContent(), $signingSecret);
        return hash_equals($signature, $computedSignature);
        }

}