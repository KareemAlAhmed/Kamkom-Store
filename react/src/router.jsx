import {createBrowserRouter} from "react-router-dom"
import Login from "./views/Login";
import NotFound from "./views/NotFound";
import HomePage from "./views/HomePage/HomePage";
import ProductNavigator from "./views/HomePage/jsx/ProductNavigator.jsx";
import ProductPage from "./views/HomePage/jsx/ProductPage";
import Dashboard from "./views/Dashboard/Dashboard";
import ProductsTable from "./views/Dashboard/jsx/ProductsTable.jsx";
import UsersTable from "./views/Dashboard/jsx/UsersTable.jsx";
import OrdersTable from "./views/Dashboard/jsx/OrdersTable.jsx";
import CategoriesTable from "./views/Dashboard/jsx/CategoriesTable.jsx";
import SubCategoriesTable from "./views/Dashboard/jsx/SubCategoriesTable.jsx";
import Signin from "./views/Signin";


const router =createBrowserRouter([
    {
        path: "/",
        element: <HomePage />,      
    },
    {
        path:"/login",
        element:<Login />
    },
    {
        path:"/products/:productId",
        element:<ProductNavigator />
    },
    {
        path:"/products/:word",
        element:<ProductPage />
    },
    {
        path:"/dashboard",
        element:<Dashboard />,
        children: [   
            {
                index: true, // Define index route separately
                element: <ProductsTable />,
            },
            {
              path: "/dashboard/products", // Use a full path starting from "/"
              element: <ProductsTable  />,
            },
            {
              path: "/dashboard/users", // Use a full path starting from "/"
              element: <UsersTable  />,
            },
            {
              path: "/dashboard/orders", // Use a full path starting from "/"
              element: <OrdersTable  />,
            },
            {
                path: "/dashboard/categories", // Use a full path starting from "/"
                element: <CategoriesTable  />,
            },
            {
                path: "/dashboard/subcategories", // Use a full path starting from "/"
                element: <SubCategoriesTable  />,
            },

          ], 
    },
    {
        path: "/signin", // Use a full path starting from "/"
        element: <Signin  />,
    },
    {
        path:"*",
        element:<NotFound />
    },
    
])

export default router;