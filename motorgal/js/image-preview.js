const input = document.getElementById('foto_evento');
        const preview = document.getElementById('imgPreview');
        input.addEventListener('change', function() {
            const file = this.files[0];
            preview.src = file ? URL.createObjectURL(file) : '';
        });