import Header from './Header/Header';
// import Footer from './Footer'; 

const Layout = ({ children }) => {
  return (
    <div className="app-wrapper">
      <Header />
      <main className="content">
        {children}
      </main>
      {/* <Footer /> */}
    </div>
  );
};

export default Layout;