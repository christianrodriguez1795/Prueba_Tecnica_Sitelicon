<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $user = $request->user();

        // Crear un nuevo pedido
        $order = new Order();
        $order->user_id = $user->id;
        $order->total_amount = $request->input('total_amount');
        $order->payment_status = 'pending';
        $order->save();

        // Simular la llamada a la API de pagos (Stripe o PayPal)
        try {
            $paymentResult = $this->simulatePayment($order->total_amount);

            // Actualizar el estado del pedido basado en el resultado del pago
            if ($paymentResult['status'] == 'success') {
                $order->payment_status = 'paid';
            } else {
                $order->payment_status = 'failed';
            }
            $order->save();

            // Respuesta JSON
            return response()->json([
                'order' => $order,
                'payment_status' => $order->payment_status,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al procesar el pago',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function simulatePayment($amount)
    {
        // Aquí simulas la llamada a la API de pagos
        // Ejemplo: simulación simple que siempre es exitosa
        return [
            'status' => 'success',
            'transaction_id' => '1234567890',
        ];
    }
}
