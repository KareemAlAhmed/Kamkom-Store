
import '../css/Navbar.css';
import {FaShoppingBasket, FaUser ,FaSearch , FaHeart} from 'react-icons/fa'


const Navbar = () => {
  function CgHello(){
    document.getElementById("search-text").focus();
  }
  return (
   

    <div className='toolbar-content'>
      <div className='logo'>
        <a href='/' ><h1>KamKom</h1></a>
      </div>
      <div className='toolbar-item-menu'>
          <ul>
            <li> <a href='#'>  All Categories  </a></li> 
            <li> <a href='#'>  Sales product  </a></li>  
            <li> <a href='#'>   comtact us </a></li>  
            <li> <a href='#'>   About  </a></li> 
          </ul>
      </div>

      <div className='toolbar-item-search'>
        <FaSearch onClick={CgHello} />
        <input type="text" id='search-text' placeholder="what are you looking for?"/>
      </div>
      
      <div className='toolbar-item-social'>
      <ul>
              <li><a href='#'> Sell </a> </li> 
              <li><a href='#'> <FaHeart /> </a> </li> 
              <li><a href='#'> <FaShoppingBasket /></a> </li> 
              <li> <a href='#'> <FaUser /> </a> </li> 
          </ul>
      </div>


    </div> 
  )
}

export default Navbar