<?php
// Tạo hàm để tự động tải tất cả các lớp trong thư mục
function include_phpseclib($directory) {
  foreach (glob($directory . '/*.php') as $file) {
    require_once $file; // Bao gồm tất cả các tệp PHP trong thư mục
  }

  // Bao gồm tất cả các thư mục con
  foreach (glob($directory . '/*', GLOB_ONLYDIR) as $subdir) {
    include_phpseclib($subdir); // Đệ quy bao gồm các thư mục con
  }
}

// Gọi hàm để bao gồm tất cả các tệp PHP trong thư viện phpseclib
include_phpseclib(__DIR__);
