<?php $this->load->view('templates/header'); ?>

<h1>Expiring Domains (Next 30 Days)</h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Domain Name</th>
            <th>Expiration Date</th>
            <th>Days Left</th>
            <th>Registrar</th>
            <th>Owner Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($expiring_domains as $domain): ?>
        <tr class="<?php echo $domain->days_until_expiry < 7 ? 'table-danger' : 'table-warning'; ?>">
            <td><?php echo $domain->domain_name; ?></td>
            <td><?php echo $domain->expiration_date; ?></td>
            <td><?php echo $domain->days_until_expiry; ?></td>
            <td><?php echo $domain->registrar; ?></td>
            <td><?php echo $domain->owner_email; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php $this->load->view('templates/footer'); ?>