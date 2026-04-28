<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('whatsapp_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('template_key')->unique();
            $table->text('content');
            $table->json('variables')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default templates
        $this->insertDefaultTemplates();
    }

    /**
     * Insert default WhatsApp templates
     */
    private function insertDefaultTemplates()
    {
        $templates = [
            [
                'name' => 'Konfirmasi Order',
                'template_key' => 'order_confirmation',
                'content' => "Halo {{customer_name}},\n\nTerima kasih atas pembelian Anda!\n\n📋 *Detail Order:*\n📦 Kode Order: {{order_code}}\n💰 Total: Rp. {{total_amount}}\n📅 Tanggal: {{order_date}}\n\nSilakan lakukan pembayaran ke rekening berikut:\n🏦 {{bank_name}}\n👤 {{bank_account_name}}\n#️⃣ {{bank_account_number}}\n\nBatas waktu pembayaran: {{expiry_time}}\n\nSetelah transfer, silakan upload bukti pembayaran di akun Anda.\n\nTerima kasih! 🙏",
                'variables' => ['customer_name', 'order_code', 'total_amount', 'order_date', 'bank_name', 'bank_account_name', 'bank_account_number', 'expiry_time'],
                'description' => 'Template untuk konfirmasi order baru',
            ],
            [
                'name' => 'Pengingat Pembayaran',
                'template_key' => 'payment_reminder',
                'content' => "Halo {{customer_name}},\n\n⚠️ *Pengingat Pembayaran* ⚠️\n\nAnda memiliki tagihan yang belum dibayar:\n📋 Kode Order: {{order_code}}\n💰 Total: Rp. {{total_amount}}\n⏰ Sisa Waktu: {{time_remaining}}\n\nSilakan selesaikan pembayaran segera untuk menghindari pembatalan otomatis.\n\nTransfer ke:\n🏦 {{bank_name}}\n👤 {{bank_account_name}}\n#️⃣ {{bank_account_number}}\n\nUpload bukti transfer di: {{payment_link}}\n\nTerima kasih! 🙏",
                'variables' => ['customer_name', 'order_code', 'total_amount', 'time_remaining', 'bank_name', 'bank_account_name', 'bank_account_number', 'payment_link'],
                'description' => 'Template untuk pengingat pembayaran',
            ],
            [
                'name' => 'Pembayaran Dikonfirmasi',
                'template_key' => 'payment_confirmation',
                'content' => "Halo {{customer_name}},\n\n✅ *Pembayaran Berhasil Dikonfirmasi*\n\nTerima kasih atas pembayaran Anda!\n\n📋 *Detail:*\n📦 Kode Order: {{order_code}}\n💰 Jumlah: Rp. {{paid_amount}}\n📅 Tanggal: {{payment_date}}\n\nPesanan Anda akan segera diproses.\n\nSalam hangat,\nTim Azzia 🙏",
                'variables' => ['customer_name', 'order_code', 'paid_amount', 'payment_date'],
                'description' => 'Template untuk konfirmasi pembayaran',
            ],
            [
                'name' => 'Order Selesai',
                'template_key' => 'order_completed',
                'content' => "Halo {{customer_name}},\n\n🎉 *Order Selesai!* 🎉\n\nPesanan Anda telah selesai diproses:\n📋 Kode Order: {{order_code}}\n📦 Produk: {{product_name}}\n📅 Tanggal Selesai: {{completion_date}}\n\nAnda dapat mengakses produk Anda di dashboard member.\n\nTerima kasih telah berbelanja di Azzia!\n\nSalam,\nTim Azzia 🙏",
                'variables' => ['customer_name', 'order_code', 'product_name', 'completion_date'],
                'description' => 'Template untuk order yang telah selesai',
            ],
            [
                'name' => 'Pembayaran Royalty',
                'template_key' => 'royalty_payment',
                'content' => "Halo {{user_name}},\n\n💰 *Pembayaran Royalty* 💰\n\nSelamat! Anda telah menerima pembayaran royalty:\n\n📋 *Detail:*\n💵 Jumlah: Rp. {{amount}}\n📖 Buku: {{book_title}}\n📅 Tanggal: {{payment_date}}\n\nPembayaran telah dikirim ke rekening Anda.\n\nTerus berkarya dan semangat!\n\nSalam,\nTim Azzia 🙏",
                'variables' => ['user_name', 'amount', 'book_title', 'payment_date'],
                'description' => 'Template untuk pembayaran royalty',
            ],
            [
                'name' => 'Buku Diterbitkan',
                'template_key' => 'book_published',
                'content' => "Halo {{user_name}},\n\n📚 *Selamat! Buku Anda Telah Diterbitkan* 📚\n\nKami dengan senang hati mengumumkan bahwa buku Anda telah berhasil diterbitkan:\n\n📖 Judul: {{book_title}}\n📅 Tanggal Terbit: {{publish_date}}\n\nBuku Anda sekarang tersedia untuk dibeli di platform kami.\n\nSemoga buku ini memberikan manfaat bagi banyak pembaca!\n\nSalam sukses,\nTim Azzia 🙏",
                'variables' => ['user_name', 'book_title', 'publish_date'],
                'description' => 'Template untuk pemberitahuan buku diterbitkan',
            ],
            [
                'name' => 'Editor Disetujui',
                'template_key' => 'editor_approved',
                'content' => "Halo {{user_name}},\n\n✅ *Selamat! Klaim Editor Disetujui* ✅\n\nPermintaan Anda untuk menjadi editor pada buku berikut telah disetujui:\n\n📖 Judul Buku: {{book_title}}\n📅 Tanggal Disetujui: {{approval_date}}\n\nAnda dapat segera memulai pekerjaan editing.\n\nSemoga sukses dalam proses editingnya!\n\nSalam,\nTim Azzia 🙏",
                'variables' => ['user_name', 'book_title', 'approval_date'],
                'description' => 'Template untuk persetujuan klaim editor',
            ],
        ];

        foreach ($templates as $template) {
            \App\Models\WhatsAppTemplate::create($template);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_templates');
    }
};
