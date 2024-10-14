const express = require('express');
const ytdl = require('ytdl-core');
const app = express();
const port = 3000;

// Servir archivos estáticos (HTML, CSS, etc.)
app.use(express.static('public'));

// Ruta para manejar las descargas
app.get('/download', (req, res) => {
    const videoUrl = req.query.url;
    const format = req.query.format;

    if (!ytdl.validateURL(videoUrl)) {
        return res.status(400).send('El enlace de YouTube no es válido.');
    }

    const options = format === 'audio' ? { filter: 'audioonly' } : {};

    res.header('Content-Disposition', `attachment; filename="video.${format === 'audio' ? 'mp3' : 'mp4'}"`);

    // Iniciar la descarga con el formato seleccionado
    ytdl(videoUrl, options).pipe(res);
});

// Iniciar el servidor
app.listen(port, () => {
    console.log(`Servidor funcionando en http://localhost:${port}`);
});
