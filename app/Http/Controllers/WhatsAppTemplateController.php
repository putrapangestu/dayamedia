<?php

namespace App\Http\Controllers;

use App\Models\WhatsAppTemplate;
use Illuminate\Http\Request;

class WhatsAppTemplateController extends Controller
{
    /**
     * Display a listing of WhatsApp templates.
     */
    public function index()
    {
        $templates = WhatsAppTemplate::paginate(10);

        return view('admin.pages.settings.whatsapp-templates', compact('templates'));
    }

    /**
     * Show the form for editing a specific template.
     */
    public function edit(string $id)
    {
        $template = WhatsAppTemplate::findOrFail($id);

        return view('admin.pages.settings.whatsapp-template-edit', compact('template'));
    }

    /**
     * Update the specified template.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string|max:500',
        ]);

        $template = WhatsAppTemplate::findOrFail($id);

        // Extract variables from content
        preg_match_all('/\{\{(\w+)\}\}/', $request->content, $matches);
        $variables = array_unique($matches[1]);

        $template->update([
            'name' => $request->name,
            'content' => $request->content,
            'status' => $request->status,
            'description' => $request->description,
            'variables' => $variables,
        ]);

        return redirect()->route('admin.whatsapp-templates.index')
            ->with('success', 'Template WhatsApp berhasil diperbarui.');
    }

    /**
     * Preview template with sample variables.
     */
    public function preview(string $id)
    {
        $template = WhatsAppTemplate::findOrFail($id);

        // Sample data for preview
        $sampleData = [
            'customer_name' => 'Budi Santoso',
            'order_code' => 'ORD-2024-001',
            'total_amount' => '150.000',
            'order_date' => date('d/m/Y'),
            'bank_name' => 'Bank Mandiri',
            'bank_account_name' => 'PT Daya Media',
            'bank_account_number' => '1234567890',
            'expiry_time' => '24 jam',
            'time_remaining' => '12 jam',
            'payment_link' => url('/payment'),
            'paid_amount' => '150.000',
            'payment_date' => date('d/m/Y H:i'),
            'product_name' => 'Buku Panduan Laravel',
            'completion_date' => date('d/m/Y'),
            'user_name' => 'Andi Wijaya',
            'amount' => '50.000',
            'book_title' => 'Panduan Lengkap Laravel',
            'publish_date' => date('d/m/Y'),
            'approval_date' => date('d/m/Y H:i'),
        ];

        $preview = $template->process($sampleData);

        return response()->json([
            'template' => $template,
            'preview' => $preview,
            'variables' => $template->variables,
        ]);
    }

    /**
     * Send test WhatsApp message.
     */
    public function sendTest(Request $request, string $id)
    {
        $request->validate([
            'phone_number' => 'required|string|regex:/^\d{10,15}$/',
            'variables' => 'nullable|array',
        ]);

        $template = WhatsAppTemplate::findOrFail($id);

        if ($template->status !== WhatsAppTemplate::STATUS_ACTIVE) {
            return response()->json([
                'success' => false,
                'message' => 'Template tidak aktif.',
            ], 400);
        }

        // Process template with variables
        $message = $template->process($request->variables ?? []);

        // Here you would integrate with your WhatsApp API
        // For now, we'll simulate the sending
        try {
            // Simulate WhatsApp API call
            $this->sendWhatsAppMessage($request->phone_number, $message);

            return response()->json([
                'success' => true,
                'message' => 'Pesan WhatsApp berhasil dikirim.',
                'content' => $message,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim pesan: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Simulate WhatsApp message sending.
     * In production, integrate with actual WhatsApp API.
     */
    private function sendWhatsAppMessage(string $phoneNumber, string $message)
    {
        // This is a simulation. Replace with actual WhatsApp API integration.
        // Example integration with WhatsApp Business API or third-party services
        // like Twilio, MessageBird, etc.

        // Log the message for testing
        \Log::info('WhatsApp message sent', [
            'phone' => $phoneNumber,
            'message' => $message,
            'timestamp' => now(),
        ]);

        return true;
    }
}
