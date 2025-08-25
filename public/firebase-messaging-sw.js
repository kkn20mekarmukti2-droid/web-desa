importScripts('https://www.gstatic.com/firebasejs/8.8.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.8.0/firebase-messaging.js');

const firebaseConfig = {
    apiKey: "AIzaSyAFOo7lt71YyIzi427bwq0oHAUnV1iRodw",
    authDomain: "desa-mekarmukti-fd401.firebaseapp.com",
    projectId: "desa-mekarmukti-fd401",
    storageBucket: "desa-mekarmukti-fd401.appspot.com",
    messagingSenderId: "746476888177",
    appId: "1:746476888177:web:556ddab389c652bc623bd0",
    measurementId: "G-FTPYHFGE5L"
  };

firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function (payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon,
        data: {
            link: payload.data.link
        }
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});

self.addEventListener('notificationclick', function(event) {
    const link = event.notification.data.link;
    event.notification.close();
    event.waitUntil(
        clients.openWindow(link)
    );
});
