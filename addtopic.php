<div class="w-25 mx-auto card p-2">
    <input type="text" name="name" id="name" placeholder="Téma neve" class="mb-1">
    <input type="button" value="Hozzáadás" onclick="addTopic()">
</div>

<script>
    addTopic = () => {
        fetch('api.php?addTopic&name=' + document.getElementById('name').value).then(response => {
            window.location.href="?admin"
        })
    }
</script>