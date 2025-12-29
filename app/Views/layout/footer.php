<footer class="main-footer">
    <p>© 2025 AN Hotel — All Rights Reserved</p>

    <div class="social-icons">
        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="#"><i class="fa-brands fa-instagram"></i></a>
    </div>
</footer>

<script src="<?= base_url('js/main.js') ?>"></script>
<script>
    function closeModal() {
        const modal = document.querySelector('.login-modal-overlay');
        if (modal) {
            modal.style.display = 'none';
        }
    }
</script>

</body>

</html>