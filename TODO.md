# Mailler Railway Fix TODO

## Current Status
✅ Plan approved by user

## Steps:
- [ ] 1. Create config.php (env vars for SMTP/fallback)
- [ ] 2. Update composer.json (modern PHPMailer) → `composer install`
- [ ] 3. Refactor backend.php (v6 PHPMailer, PHP mail() fallback, security)
- [ ] 4. Add CSRF/validation to index.php  
- [ ] 5. Add CSRF check to send.php
- [ ] 6. Basic security mailler.php (optional)
- [ ] 7. Test PHP mail() fallback locally
- [ ] 8. Deploy Railway, test SMTP + fallback
- [ ] 9. Verify security (CSRF, rate limit)

**Next:** config.php
