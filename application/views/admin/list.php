<!-- views/admin/list.php -->
<!DOCTYPE html>
<html>
<head>
    <title>License List</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>License Manager</h1>
    <a href="<?php echo site_url('admin/add'); ?>">Add New License</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>API Key</th>
                <th>License Key</th>
                <th>Domain</th>
                <th>Status</th>
                <th>Expires At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($licenses as $license): ?>
                <tr>
                    <td><?php echo $license->id; ?></td>
                    <td><?php echo $license->api_key; ?></td>
                    <td><?php echo $license->license_key; ?></td>
                    <td><?php echo $license->domain; ?></td>
                    <td><?php echo $license->status; ?></td>
                    <td><?php echo $license->expires_at; ?></td>
                    <td>
                        <a href="<?php echo site_url('admin/edit/'.$license->id); ?>">Edit</a> |
                        <a href="<?php echo site_url('admin/delete/'.$license->id); ?>" onclick="return confirm('Delete this license?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

