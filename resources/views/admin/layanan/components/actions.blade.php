<div class="btn-group">
    <button class="btn btn-sm btn-primary" onclick="editLayanan({{ $layanan->id }})">Edit</button>
    <button class="btn btn-sm btn-info" onclick="berkasLayanan({{ $layanan->id }})">Berkas</button>
    <button class="btn btn-sm btn-success" onclick="syaratLayanan({{ $layanan->id }})">Syarat</button>
    <button class="btn btn-sm btn-danger " onclick="deleteLayanan({{ $layanan->id }})">Delete</button>
</div>
