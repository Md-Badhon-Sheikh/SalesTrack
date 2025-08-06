<!-- Blade: Pass data -->
<div id="chat-data"
     data-user='@json($currentUser)'
     data-admin="{{ $isAdmin ? 'true' : 'false' }}">
</div>

<!-- Chat UI -->
<div class="p-4">
    <h3 class="text-lg font-bold mb-2">Chat With Admin</h3>
    <div id="chatWindow" class="border rounded p-3 h-64 overflow-y-auto bg-white mb-3"></div>

    <div class="flex gap-2">
        <input type="text" id="messageInput" class="flex-1 border rounded px-3 py-2" placeholder="Type your message">
        <button onclick="sendMessage()" class="bg-green-600 text-white px-4 py-2 rounded">Send</button>
    </div>
</div>

<!-- Firebase SDK -->
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.5.0/firebase-app.js";
    import { getDatabase, ref, push, onChildAdded } from "https://www.gstatic.com/firebasejs/10.5.0/firebase-database.js";

    // Firebase Config
    const firebaseConfig = {
        apiKey: "AIzaSyCNwbiZtGaqB2YaiTA1s0WxDhHVQ9-x5vU",
        authDomain: "salestrack-6a56b.firebaseapp.com",
        databaseURL: "https://salestrack-6a56b-default-rtdb.firebaseio.com",
        projectId: "salestrack-6a56b",
        storageBucket: "salestrack-6a56b.appspot.com",
        messagingSenderId: "625715367680",
        appId: "1:625715367680:web:bfdfdf46d939d72bd02de5"
    };

    const app = initializeApp(firebaseConfig);
    const db = getDatabase(app);

    // Get user data from DOM
    const chatDiv = document.getElementById('chat-data');
    const currentUser = JSON.parse(chatDiv.dataset.user);
    const isAdmin = chatDiv.dataset.admin === 'true';

    let chatPath = `chats/admin_${currentUser.id}`; // Salesman chat path
    listenForMessages();

    // Send message function
    window.sendMessage = function () {
        const messageInput = document.getElementById('messageInput');
        const message = messageInput.value.trim();
        if (!message) return;

        const chatRef = ref(db, chatPath);
        push(chatRef, {
            sender_id: currentUser.id,
            sender_name: currentUser.name,
            message: message,
            timestamp: new Date().toISOString()
        });

        messageInput.value = '';
    };

    // Receive messages
    function listenForMessages() {
        const chatRef = ref(db, chatPath);
        onChildAdded(chatRef, (snapshot) => {
            const msg = snapshot.val();
            const chatWindow = document.getElementById('chatWindow');
            const div = document.createElement('div');

            const isMe = msg.sender_id === currentUser.id;
            div.classList.add('p-2', 'mb-2', 'rounded');
            div.style.backgroundColor = isMe ? '#198754' : '#f1f1f1';
            div.style.color = isMe ? '#fff' : '#000';
            div.style.textAlign = isMe ? 'right' : 'left';

            div.innerHTML = `<strong>${msg.sender_name}:</strong> ${msg.message}`;
            chatWindow.appendChild(div);
            chatWindow.scrollTop = chatWindow.scrollHeight;
        });
    }
</script>
