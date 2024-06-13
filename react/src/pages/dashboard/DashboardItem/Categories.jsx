import { useState } from "react";
import { productsList } from "../../../../utils/baseUrl";
import "./DashboardItem.css";

const Categories = () => {
    const [showEntries, setShowEntries] = useState(10);
    const [selectedIndex, setSelectedIndex] = useState(0);
    const [splitedArrays, setSplitedArrays] = useState([
        productsList.slice(0, 10),
    ]);
    let entriesSize = Math.round(productsList.length / 10);

    const setEntries = (entries) => {
        if (entries > productsList.length) return;
        setShowEntries(entries);
        entriesSize = Math.round(productsList.length / entries);
        setSplitedArrays([]);
        setSelectedIndex(0);

        for (let i = 0; i < entriesSize; i++) {
            setSplitedArrays((prev) => {
                return [
                    ...prev,
                    productsList.slice(entries * i, entries * (i + 1)),
                ];
            });
        }
    };

    const moveToIndex = (index) => {
        setSelectedIndex(index);
    };

    const products = splitedArrays[selectedIndex];
    return (
        <div className="dashboardTable">
            <table>
                <tr>
                    <td>
                        <h5>Name</h5>
                    </td>
                    <td>
                        <h5>Acttions</h5>
                    </td>
                </tr>

                {products.map((product, index) => (
                    <tr className="dashboardDesc" key={index}>
                        <td>{product.name}</td>
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
                    {splitedArrays?.map((part, index) => (
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
export default Categories;
