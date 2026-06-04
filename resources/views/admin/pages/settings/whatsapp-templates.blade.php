@extends('admin.layouts.app')

@section('title', 'Template WhatsApp')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <x-header-page
            title="Template WhatsApp"
            description="Kelola template pesan WhatsApp"
            >
        </x-header-page>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">Daftar Template WhatsApp</h4>
                </div>

                <div class="table-responsive">
                    <table id="default_order" class="table table-bordered display text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Template</th>
                                <th>Key</th>
                                <th>Status</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($templates as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $item->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($item->content, 100) }}</small>
                                    </td>
                                    <td>
                                        <code>{{ $item->template_key }}</code>
                                    </td>
                                    <td>
                                        <span class="badge {{ $item->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $item->description ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="text-decoration-none" href="javascript:void(0)" data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical fs-4"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.whatsapp-templates.edit', $item->id) }}">
                                                        <i class="ti ti-edit me-1"></i>Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item" onclick="previewTemplate({{ $item->id }})">
                                                        <i class="ti ti-eye me-1"></i>Preview
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item" onclick="testTemplate({{ $item->id }})">
                                                        <i class="ti ti-send me-1"></i>Test Kirim
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada template WhatsApp</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $templates->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="previewContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Test Modal -->
<div class="modal fade" id="testModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Test Kirim Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="testForm">
                <div class="modal-body">
                    <input type="hidden" id="testTemplateId">
                    <div class="mb-3">
                        <label for="testPhone" class="form-label">Nomor WhatsApp</label>
                        <input type="text" class="form-control" id="testPhone" placeholder="6281234567890" required>
                        <small class="form-text text-muted">Format: 628xxxxxxxxxx</small>
                    </div>
                    <div id="testVariables"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Test</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
function previewTemplate(templateId) {
    fetch(`/admin/settings/whatsapp-templates/${templateId}/preview`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('previewContent').innerHTML = 
                `<pre style="white-space: pre-wrap; background: #f8f9fa; padding: 15px; border-radius: 5px;">${data.preview}</pre>
                 <small class="text-muted">Variables: ${data.variables.join(', ')}</small>`;
            new bootstrap.Modal(document.getElementById('previewModal')).show();
        })
        .catch(error => {
            alert('Gagal load preview: ' + error.message);
        });
}

function testTemplate(templateId) {
    document.getElementById('testTemplateId').value = templateId;
    
    fetch(`/admin/settings/whatsapp-templates/${templateId}/preview`)
        .then(response => response.json())
        .then(data => {
            let variablesHtml = '';
            data.variables.forEach(variable => {
                variablesHtml += `
                    <div class="mb-2">
                        <label class="form-label">${variable}</label>
                        <input type="text" class="form-control" name="variables[${variable}]" placeholder="Value for ${variable}">
                    </div>
                `;
            });
            document.getElementById('testVariables').innerHTML = variablesHtml;
            new bootstrap.Modal(document.getElementById('testModal')).show();
        })
        .catch(error => {
            alert('Gagal load variables: ' + error.message);
        });
}

document.getElementById('testForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const templateId = document.getElementById('testTemplateId').value;
    const phone = document.getElementById('testPhone').value;
    const formData = new FormData(this);
    const variables = {};
    
    // Extract variables
    for (let [key, value] of formData.entries()) {
        if (key.startsWith('variables[')) {
            const varName = key.match(/\[(.*?)\]/)[1];
            variables[varName] = value;
        }
    }
    
    fetch(`/admin/settings/whatsapp-templates/${templateId}/send-test`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            phone_number: phone,
            variables: variables
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Pesan test berhasil dikirim!');
            bootstrap.Modal.getInstance(document.getElementById('testModal')).hide();
        } else {
            alert('Gagal kirim: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
});
</script>
@endpush
