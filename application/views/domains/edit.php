<?php $this->load->view('templates/header'); ?>

<h1>Edit Domain</h1>

<?php echo validation_errors(); ?>

<?php echo form_open('domains/edit/'.$domain->id); ?>
    <div class="form-group">
        <label for="domain_name">Domain Name</label>
        <input type="text" name="domain_name" class="form-control" value="<?php echo $domain->domain_name; ?>" required>
    </div>
    <div class="form-group">
        <label for="registrar">Registrar</label>
        <input type="text" name="registrar" class="form-control" value="<?php echo $domain->registrar; ?>">
    </div>
    <div class="form-group">
        <label for="expiration_date">Expiration Date</label>
        <input type="date" name="expiration_date" class="form-control" value="<?php echo $domain->expiration_date; ?>" required>
    </div>
    <div class="form-group">
        <label for="owner_email">Owner Email</label>
        <input type="email" name="owner_email" class="form-control" value="<?php echo $domain->owner_email; ?>">
    </div>
    <div class="form-group">
        <label for="notes">Notes</label>
        <textarea name="notes" class="form-control"><?php echo $domain->notes; ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Update Domain</button>
</form>

<?php $this->load->view('templates/footer'); ?>