<?php namespace VojtaSvoboda\DkimSign;

use Event;
use Illuminate\Mail\Message;
use October\Rain\Mail\Mailer;
use Symfony\Component\Mime\Crypto\DkimSigner;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function boot()
    {
        // add DKIM signature to all outgoing emails
        Event::listen('mailer.prepareSend', function (Mailer $mailer, $view, Message $message) {
            // get settings
            $enabled = env('DKIM_ENABLED', false);
            $key = env('DKIM_PRIVATE_KEY');
            $domain = env('DKIM_DOMAIN', parse_url(config('app.url'))['host']);
            $selector = env('DKIM_SELECTOR', 'dkim');
            $passphrase = env('DKIM_PASSPHRASE');

            // check settings
            if (empty($enabled) || empty($key)) {
                return;
            }

            // DKIM sign
            $symfonyMessage = $message->getSymfonyMessage();
            $key_content = file_get_contents($key);
            $signer = new DkimSigner($key_content, $domain, $selector, [], $passphrase);
            $signedEmail = $signer->sign($symfonyMessage);
            $symfonyMessage->setHeaders($signedEmail->getHeaders());
        });
    }
}
