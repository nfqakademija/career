import React from "react";
import Axios from "axios";

import "./hrPage.style.scss";

import CheckBox from "../../Components/checkbox/checkbox.comp";

class HrPage extends React.Component {
  constructor() {
    super();

    this.state = {
      profiles: [],
      profileCopy: [],
      position: null,
      competenceList: [],
      criteriaList: []
    };
  }

  componentDidMount() {
    Axios.get("/api/competences")
      .then(res => {
        this.setState({ profiles: res.data });
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
      let copy = this.state.competenceList;
      let index = copy.indexOf(competenceId);
      copy.splice(index, 1);
      this.setState({ competenceList: copy });
      console.log("dd");
    }

    let copy = this.state.criteriaList;
    let index = copy.indexOf(criteriaId);
    copy.splice(index, 1);
    this.setState({ criteriaList: copy });
  };

  positonInput = e => {
    this.setState({ position: e.target.value });
  };

  submit = () => {
    let copy = [...this.state.profiles];
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
    // this.setState({ profileCopy: obj });
    this.sendData(obj);

    // this.setState({ profileCopy: obj });
  };

  sendData = obj => {
    // Axios({
    //   url: "/api/profiles",
    //   method: "post",
    //   data: obj
    // })
    //   .then(function(response) {
    //     // your action after success
    //     console.log(response);
    //   })
    //   .catch(function(error) {
    //     // your action on error success
    //     console.log(error);
    // });

    Axios.post("/api/profiles", {
      data: obj
    })
      .then(function(response) {
        // your action after success
        console.log(response);
      })
      .catch(function(error) {
        // your action on error success
        console.log(error);
      });

    // fetch("/api/profiles", {
    //   method: "POST",
    //   // headers: {
    //   //   Accept: "application/json",
    //   //   "Content-Type": "application/json"
    //   // },
    //   data: JSON.stringify(obj)
    // })
    //   .then(function(response) {
    //     // your action after success
    //     console.log(response);
    //   })
    //   .catch(function(error) {
    //     // your action on error success
    //     console.log(error);
    //   });
  };

  render() {
    return (
      <div className="hrPage">
        <label>Enter position namee: </label>
        <input type="text" onChange={e => this.positonInput(e)} />
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
        {console.log("Sukurta pozicija: ")}
        {console.log(this.state.profileCopy)}
        {/* {console.log(this.state.profileCopy)} */}
        {/* {console.log(this.props.location)} */}
      </div>
    );
  }
}

export default HrPage;
