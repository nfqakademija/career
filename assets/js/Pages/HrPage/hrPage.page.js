import React from "react";
import Axios from "axios";
// import _ from 'loadash';

import "./hrPage.style.scss";

import CheckBox from "../../Components/checkbox/checkbox.comp";
import { red } from "ansi-colors";

class HrPage extends React.Component {
  constructor() {
    super();

    this.state = {
      profiles: [],
      // profilesCopy:[],
      positions: [],
      position: null,
      competenceList: [],
      criteriaList: []
    };
  }

  componentDidMount() {
    Axios.get("/api/competences")
      .then(res => {
        // if (res.data.length === 0) {
        //   console.log("No data");
        // } else {
        this.setState({ profiles: res.data });
        // this.setState({profilesCopy: res.data})
        // }
      })
      .catch(err => console.log(err));

    Axios.get("/api/profession/list")
      .then(res => {
        this.setState({ positions: res.data });
      })
      .catch(err => console.log(err));
  }

  add = (competenceId, criteriaId) => {
    var joined = this.state.competenceList.concat(competenceId);
    this.state.competenceList.includes(competenceId)
      ? null
      : this.setState({ competenceList: joined });
    joined = this.state.criteriaList.concat(criteriaId);
    this.state.criteriaList.includes(criteriaId)
      ? null
      : this.setState({ criteriaList: joined });
  };

  remove = (competenceId, criteriaId, criteriaList) => {
    let min = criteriaList[0].id;
    let max;
    let count = 0;
    criteriaList.forEach(element => (max = element.id));
    this.state.criteriaList.forEach(element => {
      if (element >= min && element <= max) {
        count++;
      }
    });

    if (count === 1) {
      let copy = [...this.state.competenceList];
      let index = copy.indexOf(competenceId);
      copy.splice(index, 1);
      this.setState({ competenceList: copy });
      console.log("dd");
    }

    let copy = [...this.state.criteriaList];
    let index = copy.indexOf(criteriaId);
    copy.splice(index, 1);
    this.setState({ criteriaList: copy });
  };

  submit = () => {
    let copy = [...this.state.profiles];
    // let copy = this.state.profilesCopy;
    //to remove 0 which we assign below
    Array.prototype.remove = function() {
      var what,
        a = arguments,
        L = a.length,
        ax;
      while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
          this.splice(ax, 1);
        }
      }
      return this;
    };
    //if competence isn't in list it's set to 0
    copy.forEach((element, i) =>
      this.state.competenceList.includes(element.id) ? null : (copy[i] = 0)
    );

    copy.remove(0);
    //same steps but with criteria
    copy.map((data, index) =>
      data.criterias.map((criteria, i) => {
        this.state.criteriaList.includes(criteria.id)
          ? null
          : (copy[index].criterias[i] = 0);
      })
    );

    copy.map((data, index) => copy[index].criterias.remove(0));

    let obj = [
      {
        position: this.state.position
      },
      {
        competences: copy
      }
    ];
    console.log(obj);
    if (this.state.position === null || copy.length === 0) {
      alert("Select position or criterias");
    } else {
      this.sendData(obj);
    }
  };

  sendData = obj => {
    Axios.post("/api/profiles", {
      data: obj
    })
      .then(function(response) {
        console.log(response);
      })
      .catch(function(error) {
        console.log(error);
      });

    // this.setState({ competenceList: [] });
    // this.setState({ criteriaList: [] });
    this.componentDidMount();
  };

  positonInput = e => {
    console.log("ee");
    this.setState({ position: e.target.value });
  };

  render() {
    return (
      <div className="hrPage">
        <label>Choose position: </label>
        <select onChange={e => this.positonInput(e)}>
          <option id={null} value={null}>
            --Select--
          </option>
          {this.state.positions.map(positions => (
            <option key={positions.id} value={positions.id}>
              {positions.title}
            </option>
          ))}
        </select>
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
                    <td
                      className="competence"
                      rowSpan={competences.criterias.length}
                    >
                      {competences.title}
                    </td>
                    <td>{competences.criterias[0].title}</td>
                    <td>
                      <CheckBox
                        add={this.add}
                        remove={this.remove}
                        competenceId={competences.id}
                        criteriaId={competences.criterias[0].id}
                        criteriaList={competences.criterias}
                      />
                    </td>
                  </tr>

                  {competences.criterias
                    .filter((check, i) => i !== 0)
                    .map(criterias => {
                      return (
                        <tr key={criterias.id}>
                          <td>{criterias.title}</td>
                          <td>
                            <CheckBox
                              add={this.add}
                              remove={this.remove}
                              competenceId={competences.id}
                              criteriaId={criterias.id}
                              criteriaList={competences.criterias}
                            />
                          </td>
                        </tr>
                      );
                    })}
                </React.Fragment>
              );
            })}
          </tbody>
        </table>
        <button onClick={this.submit}>Save</button>
        {/* {console.log(this.state.profiles)} */}
      </div>
    );
  }
}

export default HrPage;
