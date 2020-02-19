const { app, BrowserWindow } = require("electron")

app.on("ready", () => {
	const win = new BrowserWindow({
		width: 1024,
		height: 576,
		webPreferences: {
			contextIsolation: true,
			nodeIntegration: false
		}
	})
	win.loadFile("index.html")
})

app.on("window-all-closed", () => {
	if (process.platform !== "darwin") {
		app.quit()
	}
})

app.on("activate", () => {
	if (BrowserWindow.getAllWindows().length === 0) {
		create_window()
	}
})