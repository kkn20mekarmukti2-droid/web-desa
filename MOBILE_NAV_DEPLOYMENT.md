# Manual Deployment Guide - Mobile Slide-in Drawer Navigation

## 🎯 Issue: cPanel deployment tidak terupdate otomatis

### 📝 Manual Steps untuk cPanel:

1. **SSH ke cPanel:**
   ```bash
   ssh mekh7277@desa-mekarmukti.com
   ```

2. **Navigate ke project directory:**
   ```bash
   cd /home/mekh7277/web-desa
   ```

3. **Pull latest changes:**
   ```bash
   git pull origin main
   ```

4. **Clear semua cache Laravel:**
   ```bash
   php artisan cache:clear
   php artisan config:clear  
   php artisan view:clear
   php artisan route:clear
   ```

5. **Optimize untuk production:**
   ```bash
   php artisan config:cache
   php artisan route:cache
   ```

6. **Verify deployment:**
   ```bash
   grep -n "mobileMenuPanel" resources/views/layout/app.blade.php
   ```

---

## 🔍 Troubleshooting:

### Jika file tidak terupdate:
```bash
# Force overwrite dengan git
git fetch origin
git reset --hard origin/main
```

### Jika masih gagal:
```bash
# Manual upload via File Manager cPanel
# Upload file: resources/views/layout/app.blade.php
```

---

## 📱 Testing Mobile Navigation:

1. Buka browser developer tools (F12)
2. Set device simulation ke mobile (width ≤ 991px)
3. Refresh halaman
4. Klik hamburger icon (☰) di header kanan
5. **Expected behavior:**
   - Panel slide dari kanan dengan animasi smooth
   - Background overlay semi-transparent
   - Menu links dengan hover effect orange
   - Klik X atau overlay → menu tertutup

---

## 🎨 Implementation Details:

### Key Components:
- `#mobileOverlay` - Semi-transparent overlay (rgba(0,0,0,0.5))
- `#mobileMenuPanel` - Slide panel (translateX animation)
- `openMobileMenu()` - Show panel function
- `closeMobileMenu()` - Hide panel function
- `toggleMobileDropdown()` - Dropdown functionality

### CSS Classes:
- `.mobile-nav-toggle` - Hamburger/X icon
- Panel width: 70% max 320px
- Background: #111827 (dark theme)
- Hover: #F59E0B (orange accent)

---

## 🚨 Common Issues:

1. **Cache not cleared** → Clear browser cache + Laravel cache
2. **JS not loading** → Check console for errors
3. **CSS conflicts** → Ensure independent styling
4. **Mobile not detected** → Check @media (max-width: 991px)

---

## 📞 Contact Info:
- Development: KKN Team
- Testing URL: https://desa-mekarmukti.com
- Git Repository: https://github.com/kkn20mekarmukti2-droid/web-desa
