<!-- views/admin/form.php -->
<!DOCTYPE html>
<html>
<head>
    <title><?php echo isset($license) ? 'Edit' : 'Add'; ?> License</title>
    <script>
        function generateKey(length = 32) {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let result = '';
            for (let i = 0; i < length; i++) {
                result += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return result;
        }

        function autoFillKeys() {
            document.querySelector('[name="api_key"]').value = generateKey();
            document.querySelector('[name="license_key"]').value = generateKey();
        }
    </script>
</head>
<body>
    <h1><?php echo isset($license) ? 'Edit' : 'Add'; ?> License</h1>
    <form method="post">
        <label>API Key:</label><br>
        <input type="text" name="api_key" value="<?php echo isset($license) ? $license->api_key : ''; ?>" required>
        <button type="button" onclick="document.querySelector('[name=\'api_key\']').value = generateKey();">Generate</button><br><br>

        <label>License Key:</label><br>
        <input type="text" name="license_key" value="<?php echo isset($license) ? $license->license_key : ''; ?>" required>
        <button type="button" onclick="document.querySelector('[name=\'license_key\']').value = generateKey();">Generate</button><br><br>

        <label>Domain:</label><br>
        <input type="text" name="domain" value="<?php echo isset($license) ? $license->domain : ''; ?>" required><br><br>

        <label>Status:</label><br>
        <select name="status">
            <option value="active" <?php echo (isset($license) && $license->status === 'active') ? 'selected' : ''; ?>>Active</option>
            <option value="inactive" <?php echo (isset($license) && $license->status === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
        </select><br><br>

        <label>Expires At:</label><br>
        <input type="datetime-local" name="expires_at" value="<?php echo isset($license) ? date('Y-m-d\TH:i', strtotime($license->expires_at)) : ''; ?>" required><br><br>

        <input type="submit" value="Save">
    </form>
</body>
</html>