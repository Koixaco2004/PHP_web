<!-- TinyMCE Editor -->
<script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Đợi một chút để đảm bảo TinyMCE đã load xong
    setTimeout(function() {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
        selector: '#content',
        height: 600,
        menubar: true,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount', 'emoticons',
            'codesample', 'quickbars'
        ],
        toolbar: 'undo redo | blocks | bold italic underline strikethrough | ' +
                 'forecolor backcolor | alignleft aligncenter alignright alignjustify | ' +
                 'bullist numlist outdent indent | link customImageGallery media table | ' +
                 'removeformat code fullscreen | help',
        content_style: `
            body { 
                font-family: 'Be Vietnam Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; 
                font-size: 16px;
                line-height: 1.6;
                color: ${document.documentElement.classList.contains('dark') ? '#f3f4f6' : '#1f2937'};
                background-color: ${document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff'};
            }
        `,
        skin: document.documentElement.classList.contains('dark') ? 'oxide-dark' : 'oxide',
        content_css: document.documentElement.classList.contains('dark') ? 'dark' : 'default',
        
        
        // Cấu hình thêm
        branding: false,
        promotion: false,
        resize: true,
        elementpath: false,
        statusbar: true,
        contextmenu: false,
        
        
        // Link settings
        link_assume_external_targets: 'https',
        link_default_protocol: 'https',
        
        // Table settings
        table_use_colgroups: true,
        table_toolbar: 'tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
        
        // Code sample
        codesample_languages: [
            {text: 'HTML/XML', value: 'markup'},
            {text: 'JavaScript', value: 'javascript'},
            {text: 'CSS', value: 'css'},
            {text: 'PHP', value: 'php'},
            {text: 'Python', value: 'python'},
            {text: 'Java', value: 'java'},
            {text: 'C', value: 'c'},
            {text: 'C#', value: 'csharp'},
            {text: 'C++', value: 'cpp'},
            {text: 'SQL', value: 'sql'},
            {text: 'JSON', value: 'json'}
        ],
        
        // Setup callback
        setup: function(editor) {
            // Cập nhật word count khi editor thay đổi
            editor.on('change keyup', function() {
                updateStats();
            });
            
            // Cập nhật stats lần đầu khi editor sẵn sàng
            editor.on('init', function() {
                updateStats();
            });
            
            // Đồng bộ với dark mode
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        const isDark = document.documentElement.classList.contains('dark');
                        editor.dom.setStyle(editor.getBody(), 'background-color', isDark ? '#1f2937' : '#ffffff');
                        editor.dom.setStyle(editor.getBody(), 'color', isDark ? '#f3f4f6' : '#1f2937');
                    }
                });
            });
            
            observer.observe(document.documentElement, {
                attributes: true
            });
            
            // Custom button cho image gallery
            editor.ui.registry.addButton('customImageGallery', {
                icon: 'gallery',
                tooltip: 'Chọn từ thư viện ảnh',
                onAction: function() {
                    if (typeof openImageGallery === 'function') {
                        openImageGallery(function(imageUrl) {
                            editor.insertContent('<img src="' + imageUrl + '" alt="" />');
                        });
                    }
                }
            });
        }
    });
        } else {
            console.error('TinyMCE chưa được load');
        }
    }, 100);
    
    // Function để cập nhật thống kê
    function updateStats() {
        // Safety check: đảm bảo TinyMCE đã được khởi tạo
        if (!tinymce || !tinymce.get('content')) {
            return;
        }
        
        const content = tinymce.get('content').getContent({format: 'text'});
        const wordCount = content.trim().split(/\s+/).filter(word => word.length > 0).length;
        const charCount = content.length;
        const readTime = Math.ceil(wordCount / 200); // Giả sử đọc 200 từ/phút
        
        if (document.getElementById('wordCount')) {
            document.getElementById('wordCount').textContent = wordCount.toLocaleString();
        }
        if (document.getElementById('charCount')) {
            document.getElementById('charCount').textContent = charCount.toLocaleString();
        }
        if (document.getElementById('readTime')) {
            document.getElementById('readTime').textContent = readTime + ' phút';
        }
    }
});

// Đảm bảo TinyMCE submit đúng nội dung khi form được submit
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (tinymce.get('content')) {
                tinymce.get('content').save();
            }
        });
    });
});
</script>

<style>
/* Custom styles cho TinyMCE trong dark mode */
.dark .tox .tox-menubar,
.dark .tox .tox-toolbar,
.dark .tox .tox-toolbar__primary {
    background-color: #374151 !important;
}

.dark .tox .tox-tbtn {
    color: #f3f4f6 !important;
}

.dark .tox .tox-tbtn:hover {
    background-color: #4b5563 !important;
}

.dark .tox .tox-statusbar {
    background-color: #374151 !important;
    color: #f3f4f6 !important;
}

.dark .tox .tox-edit-area__iframe {
    background-color: #1f2937 !important;
}

/* Ẩn toolbar cũ */
#content ~ .border.border-secondary-300 {
    display: none !important;
}
</style>
