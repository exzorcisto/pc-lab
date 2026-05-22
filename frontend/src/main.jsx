import React from 'react'
import ReactDOM from 'react-dom/client'
import { BrowserRouter } from 'react-router-dom' // Импортируем обертку
import App from './App.jsx'
import './styles/index.scss'

ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <BrowserRouter> {/* Оборачиваем всё приложение здесь */}
      <App />
    </BrowserRouter>
  </React.StrictMode>,
)