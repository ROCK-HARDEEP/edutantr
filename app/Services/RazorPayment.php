<?php

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\Error as RazorpayError;

class RazorPayment implements PaymentGatewayInterface
{
    public function processPayment($amount, array $data, array $configInput)
    {
        $razorpay = new Api($configInput['key'], $configInput['secret']);

        try {
            $paymentLink = $razorpay->paymentLink->create([
                'amount' => (int) round($amount * 100),
                'currency' => config('app.currency'),
                'description' => (string) $data['product']['product'],
                'customer' => [
                    'name' => (string) $data['customer']['name'],
                    'email' => (string) $data['customer']['email'],
                    'contact' => $this->normalizeContact($data['customer']['phone'] ?? ''),
                ],
                'callback_url' => request()->getSchemeAndHttpHost() . '/api/razorpay/payment/success/' . $data['identifier'],
                'callback_method' => 'get',
            ]);

            return redirect()->away($paymentLink['short_url']);
        } catch (RazorpayError $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function normalizeContact(mixed $phone): string
    {
        $digits = preg_replace('/\D+/', '', (string) $phone) ?? '';

        return $digits !== '' ? $digits : '9999999999';
    }
}
