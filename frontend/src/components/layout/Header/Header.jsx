import { Link } from 'react-router-dom';
import { Heart, ShoppingCart, User, ChevronDown } from 'lucide-react';
import logo from '../../../assets/logo.png';
import icon_vk from '../../../assets/icon-vk.svg';
import icon_max from '../../../assets/icon-max.svg';
import icon_tg from '../../../assets/icon-tg.svg';
import icon_avito from '../../../assets/icon-avito.svg';
import icon_2gis from '../../../assets/icon-2gis.svg';
import './Header.scss';

const Header = () => {
  return (
    <header className="header">
      <div className="header__top">
        {/* Секция лого кликабельна */}
        <Link title="На главную" to="/" className="header__logo">
          <img src={logo} alt="Logo" />
          <div className="logo-text">
            <span className="pc-text">PC</span> <span className="lab-text">Lab</span>
          </div>
        </Link>
        
        <div className="header__info">
          <div className="header__schedule">
            <span>Работаем по будням</span>
            <span className="time">9:00 - 18:00</span>
          </div>
          {/* Телефон кликабелен */}
          <a href="tel:+79991012222" className="header__phone">+7 999 101 22-22</a>
          
          <div className="header__socials">
            {/* Соцсети с hover-эффектом и ссылками */}
            <a href="https://vk.com" target="_blank" rel="noreferrer"><img src={icon_vk} alt="vk" /></a>
            <a href="https://max.ru/" target="_blank" rel="noreferrer"><img src={icon_max} alt="max" /></a>
            <a href="https://web.telegram.org/" target="_blank" rel="noreferrer"><img src={icon_tg} alt="tg" /></a>
            <a href="https://www.avito.ru/" target="_blank" rel="noreferrer"><img src={icon_avito} alt="avito" /></a>
            <a href="https://2gis.ru/" target="_blank" rel="noreferrer"><img src={icon_2gis} alt="2gis" /></a>
          </div>
        </div>
      </div>

      <hr className="header__divider" />

      <div className="header__bottom">
        <nav className="header__nav">
          <ul>
            {/* Каталог: Ссылка + Выпадающий список */}
            <li className="nav-item">
              <Link to="/catalog" className="nav-item__link">Каталог <ChevronDown size={14} /></Link>
              <ul className="dropdown">
                <li><Link to="/catalog/gaming" className="dropdown__link">Игровые компьютеры</Link></li>
                <li><Link to="/catalog/workstations" className="dropdown__link">Рабочие станции</Link></li>
              </ul>
            </li>

            {/* Услуги: Только выпадающий список */}
            <li className="nav-item">
              <span className="nav-item__link">Услуги <ChevronDown size={14} /></span>
              <ul className="dropdown">
                <li><Link to="/services/maintenance" className="dropdown__link">Техническое обслуживание</Link></li>
                <li><Link to="/services/upgrade" className="dropdown__link">Модернизация</Link></li>
                <li><Link to="/services/upgrade" className="dropdown__link">Партнерство</Link></li>
              </ul>
            </li>

            <li className="nav-item"><Link to="/configurator" className="nav-item__link">Конфигуратор</Link></li>
            <li className="nav-item"><Link to="/contacts" className="nav-item__link">Контакты</Link></li>
            <li className="nav-item"><Link to="/reviews" className="nav-item__link">Отзывы</Link></li>
          </ul>
        </nav>

        <div className="header__actions">
          <button className="action-btn"><Heart size={22} /></button>
          <button className="action-btn"><ShoppingCart size={22} /></button>
          <button className="action-btn"><User size={22} /></button>
        </div>
      </div>
    </header>
  );
};

export default Header;