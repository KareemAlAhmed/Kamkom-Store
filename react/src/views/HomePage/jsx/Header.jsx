import React from 'react'
import '../css/Header.css'
import headerImage from '../headerp.jpg';


const Header = ({title , description}) => {
    return (
                <div className='container-header'>
                    <div className='right-part'>
                        <h1>
                            {title}
                        </h1>
                        <p>
                            {description}
                        </p>
                        <input type='submit' className='bt-buy' value= 'Buy Now'  />
                        <input type='submit' className='bt-explore' value= 'Explore More'  />

                    </div>

                    <div className='left-part'>
                    <img src={headerImage} className='photo-div' alt='no photos'/>
                    </div>

                </div>
    )
}
Header.defaultProps={
    title: 'welcome to  your store',
    description : 'Here you can find anything you need at great offers and height qquality. I hope you have a wonderful visit ',
}
export default Header
