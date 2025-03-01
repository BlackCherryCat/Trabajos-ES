        </div>
    </div>

    <script defer>
        if (location.pathname.endsWith('reserva.php') ||
            location.pathname.endsWith('tramo.php') ||
            location.pathname.endsWith('form-reserva.php')) {
                let link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = 'assets/css/calendar.css';
                document.head.appendChild(link);
        }
    </script>
</body>
</html>