importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js");

firebase.initializeApp({
    apiKey: "AIzaSyCjwYsi-2cSxfAvRb4mEOgd7fLhlQQbkYA",
    authDomain: "sahab-62d2e.firebaseapp.com",
    projectId: "sahab-62d2e",
    storageBucket: "sahab-62d2e.appspot.com",
    messagingSenderId: "10965210378",
    appId: "1:10965210378:web:9b97882eacbecf5f4c56f3"

});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function ({
    data: { title, body, icon },
}) {
    return self.registration.showNotification(title, { body, icon });
});
