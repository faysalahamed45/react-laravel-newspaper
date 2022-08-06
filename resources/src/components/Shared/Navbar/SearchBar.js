import React, { useState } from "react";
// import "./SearchBar.css";
// import SearchIcon from "@material-ui/icons/Search";
// import CloseIcon from "@material-ui/icons/Close";

function SearchBar({ placeholder, data }) {
    const [filteredData, setFilteredData] = useState([]);
    const [wordEntered, setWordEntered] = useState("");

    const handleFilter = event => {
        const searchWord = event.target.value;
        setWordEntered(searchWord);
        const newFilter = data.filter(value => {
            return value.title.toLowerCase().includes(searchWord.toLowerCase());
        });

        if (searchWord === "") {
            setFilteredData([]);
        } else {
            setFilteredData(newFilter);
        }
    };

    const clearInput = () => {
        setFilteredData([]);
        setWordEntered("");
    };

    return (
        <div className="content">
            <div className="search">
                <input
                    // id="search"
                    type="text"
                    className="search__input"
                    placeholder={placeholder}
                    value={wordEntered}
                    onChange={handleFilter}
                />
                {/* <div className="searchIcon">
          {filteredData.length === 0 ? (
            <SearchIcon />
          ) : (
            <CloseIcon id="clearBtn" onClick={clearInput} />
          )}
        </div> */}
                <button
                    className="search__submit d-flex align-items-center justify-content-center h-100"
                    aria-label="submit search"
                >
                    <i className="fas fa-search"></i>
                </button>
            </div>
            {filteredData.length != 0 && (
                <div className="dataResult">
                    {filteredData.slice(0, 15).map((value, key) => {
                        return (
                           <div onClick={clearInput} className="dataItem">
                             <a

                                href={value.link}
                                target="_blank"
                            >
                                <p>{value.title} </p>
                            </a>
                           </div>
                        );
                    })}
                </div>
            )}
        </div>
    );
}

export default SearchBar;
