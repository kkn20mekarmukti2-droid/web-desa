import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.12.5/firebase-app.js';
import { getMessaging, getToken, onMessage } from 'https://www.gstatic.com/firebasejs/10.12.5/firebase-messaging.js';

const firebaseConfig = {
    apiKey: "AIzaSyAFOo7lt71YyIzi427bwq0oHAUnV1iRodw",
    authDomain: "desa-mekarmukti-fd401.firebaseapp.com",
    projectId: "desa-mekarmukti-fd401",
    storageBucket: "desa-mekarmukti-fd401.appspot.com",
    messagingSenderId: "746476888177",
    appId: "1:746476888177:web:556ddab389c652bc623bd0",
    measurementId: "G-FTPYHFGE5L"
};

const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

function subscribeForNotifications() {
    Notification.requestPermission().then((permission) => {
        if (permission === 'granted') {
            return getToken(messaging, { vapidKey: 'BBoi6fGfaYFZyV2uwStDr4C4Bv3pE1HZkIKictwAkyaxUNJjUKZHeN-Cwr8_y9I-s1aDrV-mnVG8uRHO1CJF4Ow' });
        } else {
            toastr.warning("Mohon Izinkan Notifikasi.")
        }
    }).then((currentToken) => {
        if (currentToken) {
            // console.log('FCM Token:', currentToken);
            toastr.success("Anda akan Menerima Notifikasi terkait Berita Terbaru")
            fetch('/save-token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ token: currentToken })
            });
        } else {
            console.log('Token tidak terGenerate.');
        }
    }).catch((err) => {
        console.log(err);
    });
}
if (document.getElementById('subscribeButton')) {
    document.getElementById('subscribeButton').addEventListener('click', subscribeForNotifications);
}



onMessage(messaging, (payload) => {
    console.log('Message received. ', payload);
    const { title, body } = payload.notification || {};
    const { link } = payload.data || {};
    if (title) {
        toastr.options.onclick = function () { location.href = link }
        toastr.warning(body, title);
    }
});


