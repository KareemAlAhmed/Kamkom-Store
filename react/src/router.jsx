import { createBrowserRouter } from "react-router-dom";
import NotFound from "./views/NotFound";
import App from "./App";
import ShoppingCart from "./pages/ShoppingCart/ShoppingCart";
import ProductDetails from "./pages/ProductDetails/ProductDetails";
import Dashboard from "./pages/dashboard/Dashboard";
import UserProfile from "./pages/userProfile/UserProfile";
import Auth from "./pages/auth/Auth";
import SearchPage from "./pages/SearchPage/SearchPage";

const router = createBrowserRouter([
    {
        path: "/",
        element: <App />,
    },
    {
        path: "/auth",
        element: <Auth />,
    },
    {
        path: "/cart",
        element: <ShoppingCart />,
    },
    {
        path: "/search",
        element: <SearchPage />,
    },
    {
        path: "/product/:id",
        element: <ProductDetails />,
    },
    {
        path: "/dashboard/:item",
        element: <Dashboard />,
    },
    {
        path: "/profile",
        element: <UserProfile />,
    },
    {
        path: "*",
        element: <NotFound />,
    },
]);

export default router;
