import React from "react";
import "./Profile.style.scss";

class Profile extends React.Component {
  constructor() {
    super();
  }

  handle = e => {
    console.log(e.target);
  };

  render() {
    const { name, position, all } = this.props;
    return (
      <div>
        <h5>
          Name: {name} Position: {position}
        </h5>
        <table className="Profile">
          <tbody>
            <tr className="u-textCenter">
              <th></th>
              <th>Criteria</th>
              <th>Self Evaluation</th>
              <th>Comments</th>
              <th>Team lead evaluation</th>
              <th>Overall</th>
            </tr>
            {all.map((data, index) => {
              return [
                <tr key={index + 7}>
                  <td className="u-centerCenter">{data.name}</td>
                  <td key={index}>
                    {data.list.map((list, index) => (
                      <table key={index}>
                        <tbody>
                          <tr onClick={this.handle}>
                            <td className="u-borderNone">{list.criteria}</td>
                          </tr>
                        </tbody>
                      </table>
                    ))}
                  </td>
                  <td>
                    {data.list.map((list, index) => (
                      <table key={index}>
                        <tbody>
                          <tr>
                            <td className="u-borderNone">
                              {list.selfEvaluation}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    ))}
                  </td>
                  <td>
                    {data.list.map((list, index) => (
                      <table key={index}>
                        <tbody>
                          <tr>
                            <td className="u-borderNone">{list.comments}</td>
                          </tr>
                        </tbody>
                      </table>
                    ))}
                  </td>
                  <td>
                    {data.list.map((list, index) => (
                      <table key={index}>
                        <tbody>
                          <tr>
                            <td className="u-borderNone">
                              {list.teamLeadEvaluation ? "True" : "False"}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    ))}
                  </td>
                  <td>
                    {data.list.map((list, index) => (
                      <table key={index}>
                        <tbody>
                          <tr>
                            <td className="u-borderNone">{list.overall}</td>
                          </tr>
                        </tbody>
                      </table>
                    ))}
                  </td>
                </tr>
              ];
            })}
          </tbody>
        </table>
      </div>
    );
  }
}

export default Profile;
