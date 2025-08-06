<script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-database-compat.js"></script>

<div id="chat-data"
     data-user='@json($currentUser)'
     data-admin="{{ $isAdmin ? 'true' : 'false' }}">
</div>

<script>
    const chatDiv = document.getElementById('chat-data');
    const currentUser = JSON.parse(chatDiv.dataset.user);
    const isAdmin = chatDiv.dataset.admin === 'true';
</script>
<script>
    const firebaseConfig = {
        apiKey: "AIzaSyCNwbiZtGaqB2YaiTA1s0WxDhHVQ9-x5vU",
        authDomain: "salestrack-6a56b.firebaseapp.com",
        databaseURL: "https://salestrack-6a56b-default-rtdb.firebaseio.com",
        projectId: "salestrack-6a56b",
        storageBucket: "salestrack-6a56b.appspot.com",
        messagingSenderId: "625715367680",
        appId: "1:625715367680:web:bfdfdf46d939d72bd02de5"
    };

    firebase.initializeApp(firebaseConfig);
    const db = firebase.database();


    let chatPath = null;

    if (isAdmin) {
        window.startChat = function (receiverId, receiverName) {
            chatPath = `chats/admin_${receiverId}`;
            document.getElementById('chatWith').innerText = receiverName;
            document.getElementById('chatWindow').innerHTML = '';
            listenForMessages();
        };
    } else {
        chatPath = `chats/admin_${currentUser.id}`;
        listenForMessages();
    }

    function sendMessage() {
        const messageInput = document.getElementById('messageInput');
        const message = messageInput.value.trim();
        if (message === '') return;

        const chatRef = db.ref(chatPath);
        chatRef.push({
            sender_id: currentUser.id,
            sender_name: currentUser.name,
            message: message,
            timestamp: new Date().toISOString()
        });

        messageInput.value = '';
    }

    function listenForMessages() {
        if (!chatPath) return;

        const chatRef = db.ref(chatPath);
        chatRef.off();

        chatRef.on('child_added', (snapshot) => {
            const msg = snapshot.val();
            const chatWindow = document.getElementById('chatWindow');
            const div = document.createElement('div');

            const isMe = msg.sender_id === currentUser.id;
            div.classList.add('p-2', 'rounded', 'mb-2');
            div.style.backgroundColor = isMe ? '#198754' : '#f1f1f1';
            div.style.color = isMe ? '#fff' : '#000';
            div.style.textAlign = isMe ? 'right' : 'left';

            div.innerHTML = `<strong>${msg.sender_name}:</strong> ${msg.message}`;
            chatWindow.appendChild(div);
            chatWindow.scrollTop = chatWindow.scrollHeight;
        });
    }

    window.sendMessage = sendMessage;
</script>
