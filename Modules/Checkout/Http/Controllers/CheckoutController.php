<?php

namespace Modules\Checkout\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Checkout\Entities\Order;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CheckoutController extends Controller
{

    /**
     * Crea una nueva order y simula el pago.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrder(Request $request)
    {
        // Validar la entrada
        $request->validate([
            'total_amount' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $totalAmount = $request->input('total_amount');

        // Lógica de pago (simulada)
        $paymentStatus = $this->simulatePayment($totalAmount);

        // Crear el pedido
        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $totalAmount,
            'payment_status' => $paymentStatus,
        ]);

        // Retornar respuesta JSON
        return response()->json([
            'order' => $order,
            'payment_status' => $paymentStatus,
        ], 201); // Código de estado 201 Created
    }

    /**
     * Pago simulado.
     *
     * @param float $amount
     * @return string
     */
    private function simulatePayment(float $amount): string
    {
        // Aqui se haria la peticion a la API de Paypal o Stripe para 
        // que se efectue el pago correspondiente para efectuar el pago.
        // Dado que es una simuacion solo devolveremos pagado si el amount es 
        // mayor a 0 y fallido si es menor a cero peor dejare la logica de la peticion real.
        return $amount > 0 ? 'pagado' : 'fallido';

        //Este seria una ejemplo de como hacer la peticion a la api de stripe

        // Verifica si el monto es mayor a cero
        if ($amount <= 0) {
            return 'fallido'; // El monto debe ser mayor a cero para un pago válido
        }

        // Configura la clave secreta de Stripe desde el archivo de configuración
        $stripeSecretKey = config('services.stripe.secret');

        // Crea una instancia del cliente de Stripe
        Stripe::setApiKey($stripeSecretKey);

        try {
            // Simula un pago creando una intención de pago en Stripe
            $paymentIntent = PaymentIntent::create([
                'amount' => (int)($amount * 100), // Stripe espera el monto en centimos
                'currency' => 'eur', // La moneda se establece a euros
                'payment_method_types' => ['card'], // Especificamos los metodos de pago, en este caso tarjeta
            ]);

            // Verifica el estado de la intención de pago
            if ($paymentIntent->status === 'succeeded') {
                return 'pagado'; // El pago se ha simulado exitosamente
            } else {
                return 'fallido'; // El pago no se pudo completar
            }
        } catch (\Exception $e) {
            // Maneja cualquier excepción que ocurra durante la llamada a la API de Stripe
            return 'fallido'; // Consideramos el pago como fallido en caso de excepción
        }
    }
}
