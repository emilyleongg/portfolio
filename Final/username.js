function get_username() {
    const cookie = document.cookie;
    const name = 'username';
    const nvs = cookie.split('; ');
    const span_context = document.getElementById('greeting'); // Check for greeting element here

    if (name !== '') {
        for (const nv of nvs) {
            if (nv.startsWith('username=')) {
                const username = nv.substring(name.length + 1);
                
                // If greetingElement exists, update it
                if (window.location.pathname === "/~emleong/HW8/index.php") {
                    span_context.innerHTML = `Hello, ${username}!`;
                }
                
                return username;
            }
        }
    } 
 return '';
}