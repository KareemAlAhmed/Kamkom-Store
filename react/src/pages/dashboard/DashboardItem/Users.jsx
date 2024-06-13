import { usersList } from "../../../../utils/baseUrl";
import { useState } from "react";
import "./DashboardItem.css";

const Users = () => {
    const [showEntries, setShowEntries] = useState(10);
    const [selectedIndex, setSelectedIndex] = useState(0);
    const [splitedArrays, setSplitedArrays] = useState([
        usersList.slice(0, 10),
    ]);
    let entriesSize = Math.round(usersList.length / 10);

    const setEntries = (entries) => {
        if (entries > usersList.length) return;
        setShowEntries(entries);
        entriesSize = Math.round(usersList.length / entries);
        setSplitedArrays([]);
        setSelectedIndex(0);

        for (let i = 0; i < entriesSize; i++) {
            setSplitedArrays((prev) => {
                return [
                    ...prev,
                    usersList.slice(entries * i, entries * (i + 1)),
                ];
            });
        }
    };

    const moveToIndex = (index) => {
        setSelectedIndex(index);
    };

    const users = splitedArrays[selectedIndex];

    return (
        <div className="dashboardTable">
            <table>
                <tr>
                    <td>
                        <h5>FirstName</h5>
                    </td>
                    <td>
                        {" "}
                        <h5>LastName</h5>
                    </td>
                    <td>
                        {" "}
                        <h5>Email</h5>
                    </td>
                    <td className="notImp">
                        {" "}
                        <h5>Mobile Number</h5>
                    </td>
                    <td className="notImp">
                        {" "}
                        <h5>Balance</h5>
                    </td>
                    <td className="notImp">
                        {" "}
                        <h5>Country</h5>
                    </td>
                    <td className="notImp">
                        <h5>City</h5>
                    </td>
                    <td>
                        <h5>Action</h5>
                    </td>
                </tr>

                {users.map((user, index) => (
                    <tr className="dashboardDesc" key={index}>
                        <td>{user.firstname}</td>
                        <td>{user.lastname}</td>
                        <td>{user.email}</td>
                        <td className="notImp">{user.phoneNumber}</td>
                        <td className="notImp">{user.purchaseAmount}</td>
                        <td className="notImp">{user.country}</td>
                        <td className="notImp">{user.city}</td>
                        <td>
                            <button className="dashBtn">X</button>
                        </td>
                    </tr>
                ))}
            </table>
            <div className="lastRow">
                <div className="lastRowPart">
                    <h4>show entries:</h4>
                    <div
                        onClick={() => setEntries(10)}
                        className={10 == showEntries ? "selectedSlider" : ""}
                    >
                        10
                    </div>
                    <div
                        onClick={() => setEntries(15)}
                        className={15 == showEntries ? "selectedSlider" : ""}
                    >
                        15
                    </div>
                    <div
                        onClick={() => setEntries(20)}
                        className={20 == showEntries ? "selectedSlider" : ""}
                    >
                        20
                    </div>
                </div>
                <div className="lastRowPart">
                    {splitedArrays.map((part, index) => (
                        <div
                            onClick={() => {
                                moveToIndex(index);
                            }}
                            className={`slider ${
                                selectedIndex == index ? "selectedSlider" : ""
                            }`}
                        >
                            {index + 1}
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
};
export default Users;
