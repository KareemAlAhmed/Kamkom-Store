import { FaFacebook,FaTwitter,FaInstagram } from "react-icons/fa"
import '../css/Footer.css'
const Footer = () => {
  return (
    <div class="container">
      <div class="footer-logo">
      </div>
      <nav class="footer-navigation">
        <ul>
          <li><a href="#">Terms of Service</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Shipping Information</a></li>
          <li><a href="#">Returns & Refunds</a></li>
        </ul>
      </nav>
      <div class="contact-info">
        <p>Contact Us: kamkom-Store@gmail.com</p>
        <p>Phone: 01-03 60 90</p>
      </div>
      <div class="social-media">
        <a href="#"><FaFacebook /> </a>
        <a href="#">< FaInstagram /></a>
        <a href="#">< FaTwitter /></a>
      </div>
    </div>
  )
}

export default Footer
