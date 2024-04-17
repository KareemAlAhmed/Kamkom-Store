import './App.css';
import Header from './Components/HomePage/jsx/Header';
import Navbar from './Components/HomePage/jsx/Navbar';

import DisplayCategories from './Components/HomePage/jsx/DisplayCategories';
import Footer from './Components/HomePage/jsx/Footer';

function App() {
  return (
    <div className="App">
        <Navbar />
      <div className='big-container'>
        <Header />

        <DisplayCategories />
      </div>
        <Footer />



      </div>
  );
}

export default App;