import React from 'react'
import Navbar from '../HomePage/jsx/Navbar';
import Footer from '../HomePage/jsx/Footer';
import "./dashboard.css";
import Options from './jsx/Options';
import DashTable from './jsx/DashTable';
import { Outlet } from 'react-router-dom';
export default function Dashboard() {
  return (
    <>
        <Navbar />
        <div className="dashboard">
            <Options />
            <Outlet />
        </div>
        <Footer/>
        </>
  )
}
