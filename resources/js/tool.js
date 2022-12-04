import Tool from './pages/Tool'

let Nova = window.Nova;

Nova.booting((app, store) => {
  Nova.inertia('ResetPassword', Tool)
})
