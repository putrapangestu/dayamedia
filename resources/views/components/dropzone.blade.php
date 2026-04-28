{{-- resources/views/components/dropzone.blade.php --}}
@props([
    'name' => 'file',
    'id' => null,
    'accept' => 'image/*',
    'maxSize' => 5, // MB
    'required' => false,
    'label' => 'Upload File',
    'helperText' => 'Drag & drop file atau klik untuk memilih',
])

@php
    $componentId = $id ?? 'dropzone-' . uniqid();
    $inputId = $componentId . '-input';
@endphp

<div class="dropzone-wrapper" data-dropzone-id="{{ $componentId }}">
    @if($label)
    <label class="">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    @endif

    <!-- Hidden File Input -->
    <input
        type="file"
        id="{{ $inputId }}"
        name="{{ $name }}"
        accept="{{ $accept }}"
        class="dropzone-file-input"
        {{ $required ? 'required' : '' }}
    >

    <!-- Dropzone Area -->
    <div class="dropzone-area" data-input-id="{{ $inputId }}">
        <div class="dropzone-content">
            <div class="dropzone-icon">
                <i class="fas fa-cloud-upload-alt"></i>
            </div>
            <div class="dropzone-text">
                <strong>{{ $helperText }}</strong>
            </div>
            <div class="dropzone-subtext">
                <small class="text-muted">
                    Maksimal {{ $maxSize }}MB •
                    {{ strtoupper(str_replace([
                        'image/*',
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                    ], ['JPG, PNG, GIF','PDF','DOC','DOCX'], $accept)) }}
                </small>
            </div>
        </div>
    </div>

    <!-- File Preview -->
    <div class="dropzone-preview d-none">
        <div class="preview-card">
            <div class="preview-image-container">
                <img src="" alt="Preview" class="preview-image d-none">
                <div class="preview-icon d-none">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
            <div class="preview-info">
                <div class="preview-filename"></div>
                <div class="preview-filesize"></div>
            </div>
            <button type="button" class="preview-remove-btn">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    @error($name)
        <div class="text-danger small mt-2">{{ $message }}</div>
    @enderror
</div>

<style>
.dropzone-wrapper {
    margin-bottom: 1rem;
}

.dropzone-area {
    border: 2px dashed #EE128C;
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: rgba(238, 18, 140, 0.1);
}

.dropzone-area:hover {
    border-color: #EE128C;
    background: rgba(238, 18, 140, 0.2);
}

.dropzone-area.dragover {
    border-color: #10b981;
    background: rgba(238, 18, 140, 0.2);
    transform: scale(1.02);
}

.dropzone-icon {
    font-size: 2.5rem;
    color: #EE128C;
    margin-bottom: 12px;
}

.dropzone-text {
    font-size: 1rem;
    color: #334155;
    margin-bottom: 8px;
}

.dropzone-subtext {
    font-size: 0.85rem;
    color: #64748b;
}

/* Preview Styles */
.dropzone-preview {
    margin-top: 15px;
}

.preview-card {
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 15px;
    background: white;
    display: flex;
    align-items: center;
    gap: 15px;
    position: relative;
}

.preview-image-container {
    flex-shrink: 0;
    width: 80px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.preview-icon {
    font-size: 2rem;
    color: #64748b;
}

.preview-info {
    flex: 1;
    min-width: 0;
}

.preview-filename {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.preview-filesize {
    font-size: 0.85rem;
    color: #64748b;
}

.preview-remove-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #ef4444;
    color: white;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.preview-remove-btn:hover {
    background: #dc2626;
    transform: scale(1.1);
}

.dropzone-file-input {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
    overflow: hidden;
    pointer-events: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropzoneId = '{{ $componentId }}';
    const wrapper = document.querySelector(`[data-dropzone-id="${dropzoneId}"]`);
    const dropzoneArea = wrapper.querySelector('.dropzone-area');
    const fileInput = wrapper.querySelector('.dropzone-file-input');
    const preview = wrapper.querySelector('.dropzone-preview');
    const removeBtn = wrapper.querySelector('.preview-remove-btn');
    const maxSize = {{ $maxSize }} * 1024 * 1024; // Convert MB to bytes

    // Click to select file
    dropzoneArea.addEventListener('click', function() {
        fileInput.click();
    });

    // File input change
    fileInput.addEventListener('change', function(e) {
        handleFile(e.target.files[0]);
    });

    // Drag & Drop events
    dropzoneArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropzoneArea.classList.add('dragover');
    });

    dropzoneArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropzoneArea.classList.remove('dragover');
    });

    dropzoneArea.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropzoneArea.classList.remove('dragover');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFile(files[0]);

            // Set file to input
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(files[0]);
            fileInput.files = dataTransfer.files;
        }
    });

    // Handle file
    function handleFile(file) {
        if (!file) return;

        // Validate file size
        if (file.size > maxSize) {
            alert(`File terlalu besar. Maksimal {{ $maxSize }}MB.`);
            fileInput.value = '';
            return;
        }

        // Validate file type
        const acceptTypes = '{{ $accept }}'.split(',').map(t => t.trim());
        const fileType = file.type;
        let isValid = false;

        acceptTypes.forEach(type => {
            if (type.includes('*')) {
                const category = type.split('/')[0];
                if (fileType.startsWith(category)) {
                    isValid = true;
                }
            } else if (fileType === type) {
                isValid = true;
            }
        });

        if (!isValid) {
            alert('Tipe file tidak didukung.');
            fileInput.value = '';
            return;
        }

        // Show preview
        showPreview(file);
    }

    // Show preview
    function showPreview(file) {
        const previewImage = wrapper.querySelector('.preview-image');
        const previewIcon = wrapper.querySelector('.preview-icon');
        const previewFilename = wrapper.querySelector('.preview-filename');
        const previewFilesize = wrapper.querySelector('.preview-filesize');

        // Hide dropzone, show preview
        dropzoneArea.style.display = 'none';
        preview.classList.remove('d-none');

        // Set filename and size
        previewFilename.textContent = file.name;
        previewFilesize.textContent = formatFileSize(file.size);

        // Show image or icon
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.classList.remove('d-none');
                previewIcon.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            previewImage.classList.add('d-none');
            previewIcon.classList.remove('d-none');

            // Set icon based on file type
            const iconElement = previewIcon.querySelector('i');
            if (file.type === 'application/pdf') {
                iconElement.className = 'fas fa-file-pdf text-danger';
            } else if (file.type.includes('word')) {
                iconElement.className = 'fas fa-file-word text-primary';
            } else if (file.type.includes('sheet') || file.type.includes('excel')) {
                iconElement.className = 'fas fa-file-excel text-success';
            } else {
                iconElement.className = 'fas fa-file-alt text-secondary';
            }
        }
    }

    // Remove file
    removeBtn.addEventListener('click', function() {
        fileInput.value = '';
        dropzoneArea.style.display = 'block';
        preview.classList.add('d-none');
    });

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }
});
</script>
