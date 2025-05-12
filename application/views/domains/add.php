<?php $this->load->view('templates/header'); ?>

<h1>Add Domain</h1>

<?php echo validation_errors(); ?>

<?php echo form_open('domains/add'); ?>
    <div class="form-group">
        <label for="domain_name">Domain Name</label>
        <input type="text" name="domain_name" class="form-control" required>
        <small class="form-text text-muted">Example: example.com (http:// is optional)</small>
    </div>
    <button type="submit" class="btn btn-primary">Add Domain</button>
</form>

<?php $this->load->view('templates/footer'); ?>