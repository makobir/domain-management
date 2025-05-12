<?php $this->load->view('templates/header'); ?>

<h1>Domain Management</h1>
<a href="<?php echo site_url('domains/add'); ?>" class="btn btn-primary">Add Domain</a>
<a href="<?php echo site_url('domains/check_expiring'); ?>" class="btn btn-warning">Check Expiring Domains</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Domain Name</th>
            <th>Registrar</th>
            <th>Expiration Date</th>
            <th>Days Left</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($domains as $domain): ?>
        <tr class="<?php echo $domain->days_until_expiry < 30 ? 'table-warning' : ''; ?>">
            <td><?php echo $domain->domain_name; ?></td>
            <td><?php echo $domain->registrar; ?></td>
            <td><?php echo $domain->expiration_date; ?></td>
            <td><?php echo $domain->days_until_expiry; ?></td>
            <td><?php echo $domain->status; ?></td>
            <td>
                <a href="<?php echo site_url('domains/edit/'.$domain->id); ?>" class="btn btn-sm btn-info">Edit</a>
                <a href="<?php echo site_url('domains/refresh/'.$domain->id); ?>" class="btn btn-sm btn-secondary">Refresh</a>
                <a href="<?php echo site_url('domains/delete/'.$domain->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php $this->load->view('templates/footer'); ?>