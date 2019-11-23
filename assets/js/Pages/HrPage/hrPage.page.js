import React from "react";
import Axios from "axios";

import './hrPage.style.scss'

class HrPage extends React.Component {
  constructor() {
    super();

    this.state = {
      profiles: []
    };
  }

  componentDidMount() {
    Axios.get("/api/competence/list")
      .then(res => this.setState({ profiles: res.data }))
      .catch(err => console.log(err));
  }

  render() {
    return (
      <div className="hrPage">
        <label>Enter position name: </label>
        <input type="text"/>
        <table className="Profile">
          <tbody>
            <tr className="u-textCenter">
              <th></th>
              <th>Criteria</th>
            </tr>
            {this.state.profiles.map(competences => {
              return (
                <React.Fragment key={competences.id}>
                  <tr>
                    <td className="competence" rowSpan={competences.criterias.length}>
                      {competences.title}
                    </td>
                    <td>{competences.criterias[0].title}</td>
                    <td><input type="checkbox" name="add"/></td>
                  </tr>

                  {competences.criterias
                    .filter((check, i) => i !== 0)
                    .map(criterias => {
                      return (
                        <tr key={criterias.id}>
                          <td>{criterias.title}</td>
                          <td><input type="checkbox" name="add"/></td>
                        </tr>
                      );
                    })}
                </React.Fragment>
              );
            })}
          </tbody>
        </table>
        <button>Save</button>
      </div>
    );
  }
}

export default HrPage;
