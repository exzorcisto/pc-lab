import './Home.scss';

const Home = () => {
  return (
    <section className="home">
      <div className="container">
        {/* Здесь будет Hero Section */}
        <div style={{ padding: '100px 0', textAlign: 'center' }}>
          <h1 style={{ fontSize: '48px', color: '#fff' }}>
            Наши мощные компьютеры <br /> 
            <span style={{ color: '#00A36C' }}>под любые ваши задачи</span>
          </h1>
        </div>
      </div>
    </section>
  );
};

export default Home;