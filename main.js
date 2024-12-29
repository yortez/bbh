const { app, BrowserWindow } = require('electron')
const path = require('node:path')
const createWindow = () => {
  const win = new BrowserWindow({
    width: 800,
    height: 600
  })
  win.loadURL('http://127.0.0.1:8000/admin')
}

app.whenReady().then(() => {
  createWindow()
})