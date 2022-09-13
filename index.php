<script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "AIzaSyBlaoMFcRFe-yXJUoXguE5TiUxUpD3Rzo8",
        authDomain: "AIzaSyBlaoMFcRFe-yXJUoXguE5TiUxUpD3Rzo8",
        databaseURL: "https://colonelchat-413fd-default-rtdb.firebaseio.com/",
        projectId: "colonelchat-413fd",
        storageBucket: "colonelchat-413fd.appspot.com",
        messagingSenderId: "136288649762",
        appId: "1:136288649762:web:8aeaf727568aac9449007b"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
 
    var myName = prompt("Enter your name");
</script>
     
<!-- create a form to send message -->
<form onsubmit="return sendMessage();">
    <input id="message" placeholder="Enter message" autocomplete="off">
 
    <input type="submit">
</form>
     
<script>
    function sendMessage() {
        // get message
        var message = document.getElementById("message").value;
 
        // save in database
        firebase.database().ref("messages").push().set({
            "sender": myName,
            "message": message
        });
 
        // prevent form from submitting
        return false;
    }
</script>

<!-- create a list -->
<ul id="messages"></ul>
     
<script>
    // listen for incoming messages
    firebase.database().ref("messages").on("child_added", function (snapshot) {
        var html = "";
        // give each message a unique ID
        html += "<li id='message-" + snapshot.key + "'>";
        // show delete button if message is sent by me
        if (snapshot.val().sender == myName) {
            html += "<button data-id='" + snapshot.key + "' onclick='deleteMessage(this);'>";
                html += "Delete";
            html += "</button>";
        }
        html += snapshot.val().sender + ": " + snapshot.val().message;
        html += "</li>";
 
        document.getElementById("messages").innerHTML += html;
    });

    function deleteMessage(self) {
    // get message ID
    var messageId = self.getAttribute("data-id");
 
    // delete message
    firebase.database().ref("messages").child(messageId).remove();
}
 
// attach listener for delete message
firebase.database().ref("messages").on("child_removed", function (snapshot) {
    // remove message node
    document.getElementById("message-" + snapshot.key).innerHTML = "This message has been removed";
});
</script>



