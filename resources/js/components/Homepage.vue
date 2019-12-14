<template>
  <div class="container-fluid">
    <div class="row mt-5">
      <div class="col-12 col-lg-3 collection">
        <h1>Groups</h1>
        <div class="p-1 w-75" v-for="group in groups" :key="group.id">
          <div
            :class="`d-flex item m-1 ${group.id == selectedGroup ? 'active' : ''}`"
            @click="filterByGroup(group.id)"
          >
            <div class="main-part">{{group.name}}</div>

            <button class="btn btn-sm btn-dark ml-auto" @click.stop="removeGroup(group)">Delete</button>
          </div>
        </div>
        <div class="p-1">
          <button class="btn btn-sm btn-warning m-1" @click="filterByGroup(null)">Show all</button>
        </div>
      </div>
      <div class="col-12 col-lg-6 collection" :key="componentKey">
        <div class="row">
          <div class="col-12">
            <h1 class="text-center">Contacts</h1>
          </div>
        </div>
        <div class="row">
          <div
            v-if="contacts.length == 0" class="p-5 text-center w-100">
            No contacts in this group
          </div>
          <div class="col-lg-4 col-md-6 col-12 p-1" v-for="contact in contacts" :key="contact.id">
            <div class="item m-1" @click="toggleActive(contact)" :class="getActiveStatus(contact)">
              <div class="main-part">
                <div class="image" :style="getBGImageStyle(contact.avatar)"></div>
                <div class="d-flex flex-column">
                  {{contact.firstName}} {{contact.lastName}}
                  <small
                    class="text-secondary"
                  >{{ getGroupName(contact.group_id) }}</small>
                </div>
              </div>
              <div class="controls">
                <span @click.stop="toggleActive(null)">&times;</span>
              </div>
              <transition name="slide-fade">
                <div class="form" v-if="isActive(contact)" @click.stop>
                  <div :class="active.invalidFirstName">
                    First Name:
                    <input
                      type="text"
                      v-model="active.firstName"
                      @click.stop
                      @keydown="active.invalidFirstName = ''"
                    />
                  </div>
                  <div :class="active.invalidLastName">
                    Last Name:
                    <input
                      type="text"
                      v-model="active.lastName"
                      @click.stop
                      @keydown="active.invalidLastName = ''"
                    />
                  </div>
                  <div :class="active.invalidEmail">
                    Email:
                    <input
                      type="text"
                      v-model="active.email"
                      @click.stop
                      @keydown="active.invalidEmail = ''"
                    />
                  </div>
                  <div>
                    Phone:
                    <input type="text" v-model="active.phone" @click.stop />
                  </div>
                  <div>
                    Group:
                    <select v-model="active.group_id" @click.stop>
                      <option :value="null">-</option>
                      <option
                        v-for="group in groups"
                        :key="group.id"
                        :value="group.id"
                      >{{group.name}}</option>
                    </select>
                  </div>
                  <div class="mt-1">
                    <button class="btn btn-sm btn-warning mr-2" @click.stop="updateContact()">Update</button>
                    <button
                      class="btn btn-sm btn-dark"
                      @click.stop="removeContact(contact)"
                    >Delete</button>
                  </div>
                </div>
              </transition>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <ul class="pagination justify-content-center" v-if="pagination.prev || pagination.next">
              <li :class="`page-item ${pagination.first ? '' : 'disabled'}`">
                <a
                  class="page-link"
                  href="javascript:void(0)"
                  @click="paginate(pagination.first)"
                >First</a>
              </li>
              <li :class="`page-item ${pagination.prev ? '' : 'disabled'}`">
                <a
                  class="page-link"
                  href="javascript:void(0)"
                  @click="paginate(pagination.prev)"
                >Previous</a>
              </li>
              <li class="page-item">
                <span class="page-link">PAGE {{pagination.current}}</span>
              </li>
              <li :class="`page-item ${pagination.next ? '' : 'disabled'}`">
                <a
                  class="page-link"
                  href="javascript:void(0)"
                  @click="paginate(pagination.next)"
                >Next</a>
              </li>
              <li :class="`page-item ${pagination.last ? '' : 'disabled'}`">
                <a
                  class="page-link"
                  href="javascript:void(0)"
                  @click="paginate(pagination.last)"
                >Last</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-3">
        <div class="row">
          <div class="col-12">
            <h1 class="text-right p-1 pr-3">New contact</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="form p-1 pr-3">
              <div :class="newContact.invalidFirstName">
                First Name:
                <input
                  type="text"
                  v-model="newContact.firstName"
                  @click.stop
                  @keydown="newContact.invalidFirstName = ''"
                />
              </div>
              <div :class="newContact.invalidLastName">
                Last Name:
                <input
                  type="text"
                  v-model="newContact.lastName"
                  @click.stop
                  @keydown="newContact.invalidLastName = ''"
                />
              </div>
              <div :class="newContact.invalidEmail">
                Email:
                <input
                  type="text"
                  v-model="newContact.email"
                  @click.stop
                  @keydown="newContact.invalidEmail = ''"
                />
              </div>
              <div>
                Phone:
                <input type="text" v-model="newContact.phone" @click.stop />
              </div>
              <div>
                Group:
                <select v-model="newContact.group_id" @click.stop>
                  <option :value="null">-</option>
                  <option v-for="group in groups" :key="group.id" :value="group.id">{{group.name}}</option>
                </select>
              </div>
              <div class="mt-1">
                <button class="btn btn-sm btn-warning mr-2" @click.stop="saveContact()">Save</button>
                <button class="btn btn-sm btn-dark" @click.stop="newContact = {};">Reset</button>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-5">
          <div class="col-12">
            <h1 class="text-right p-1 pr-3">New group</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="form p-1 pr-3">
              <div>
                Name:
                <input type="text" v-model="newGroup.name" @click.stop />
              </div>
              <div class="mt-1">
                <button class="btn btn-sm btn-warning mr-2" @click.stop="saveGroup()">Save</button>
                <button class="btn btn-sm btn-dark" @click.stop="newGroup = {};">Reset</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <transition name="slide-fade">
      <div :class="`toast ${showToastFlag ? 'active' : ''}`" @click="showToastFlag = false">
        <div class="toast-header">
          <strong class="mr-auto">Alert</strong>
        </div>
        <div class="toast-body">{{ msg }}</div>
      </div>
    </transition>
  </div>
</template>

<style scoped>
.slide-fade-enter-active {
  transition: all 0.2s ease;
}
.slide-fade-leave-active {
  transition: all 0.5s ease(1, 0.5, 0.8, 1);
}
.slide-fade-enter, .slide-fade-leave-to {
  transform: translateY(10px);
  opacity: 0;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>

<script>
export default {
  name: "Homepage",
  data() {
    return {
      componentKey: 0,
      contacts: [],
      groups: App.groups,
      selectedGroup: null,
      active: null,
      newContact: {},
      newGroup: {},
      groupsById: {},
      pagination: {},
      showToastFlag: false,
      msg: ""
    };
  },
  methods: {
    forceRerender: function() {
      this.componentKey += 1;
    },
    getBGImageStyle: function(img) {
      return `background-image: url('${img}')`;
    },
    toggleActive: function(contact) {
      this.active = { ...contact };
    },
    getActiveStatus: function(contact) {
      return this.active != null && this.active.id == contact.id
        ? "active"
        : "";
    },
    isActive: function(contact) {
      return this.active != null && this.active.id == contact.id;
    },
    getGroupName: function(id) {
      if (id && this.groupsById[id]) {
        return this.groupsById[id].name;
      } else {
        return "-";
      }
    },
    saveGroup: function() {
      axios
        .post(`/api/groups/`, this.newGroup)
        .then(response => {
          if (response.data && response.data.status) {
            this.getGroups();
            this.newGroup = {};
          }
        })
        .catch(error => {
          console.log(error);
        });
    },
    removeGroup: function(group) {
      let flag = confirm(`Delete group: ${group.name}?`);
      if(flag){
        let id = group.id;
        axios
        .delete(`/api/groups/${id}`)
        .then(response => {
          if (response.data.status) {
            this.groups = this.groups.filter(el => {
              return el.id != id;
            });
            delete this.groupsById[id];
          }
        })
        .catch(error => {
          console.log(error);
        });
      }
    },
    saveContact: function() {
      if (!this.isValidContact(this.newContact)) {
        // this.showToast({text: 'Bad input data'});
      } else {
        axios
          .post(`/api/contacts/`, this.newContact)
          .then(response => {
            if (response.data.status) {
              this.getContacts();
              this.newContact = {};
              this.selectedGroup = null;
            }
          })
          .catch(error => {
            console.log(error);
          });
      }
    },
    updateContact: function() {
      if (!this.isValidContact(this.active)) {
        // this.showToast({text: 'Bad input data'});
      } else {
        axios
          .put(`/api/contacts/${this.active.id}`, this.active)
          .then(response => {
            if (response.data.status) {
              for (let contact of this.contacts) {
                if (contact.id == this.active.id) {
                  contact.firstName = this.active.firstName;
                  contact.lastName = this.active.lastName;
                  contact.email = this.active.email;
                  contact.phone = this.active.phone;
                  contact.group_id = this.active.group_id;
                  break;
                }
              }
              alert("Contact updated successfully");
            }
          })
          .catch(error => {
            console.log(error);
          });
      }
    },
    removeContact: function(contact) {
      let flag = confirm(`Delete ${contact.firstName} ${contact.lastName} (${contact.id})?`);
      if (flag) {
        const id = contact.id;
        axios
          .delete(`/api/contacts/${id}`)
          .then(response => {
            if (response.data.status) {
              this.contacts = this.contacts.filter(el => {
                return el.id != id;
              });
            }
          })
          .catch(error => {
            console.log(error);
          });
      }
    },
    paginate: function(endpoint) {
      axios.get(endpoint).then(response => {
        this.contacts = response.data.data;
        this.updatePagination(response.data);
      });
    },
    getContacts: function() {
      axios.get("/api/contacts").then(response => {
        this.contacts = response.data.data;
        this.updatePagination(response.data);
      });
    },
    filterByGroup: function(id) {
      let endpoint = "/api/contacts";
      endpoint = id ? endpoint + "?group_id=" + id : endpoint;
      axios.get(endpoint).then(response => {
        this.contacts = response.data.data;
        this.updatePagination(response.data);
      });
      this.selectedGroup = id;
    },
    createGroupsById: function() {
      this.groupsById = {};
      this.groups.forEach(group => {
        this.groupsById[group.id] = group;
      });
    },
    getGroups: function() {
      axios.get("/api/groups").then(response => {
        this.groups = response.data;
        this.createGroupsById();
      });
    },
    updatePagination: function(data) {
      this.pagination = {
        current: data.current_page,
        first: data.first_page_url,
        last: data.last_page_url,
        prev: data.prev_page_url,
        next: data.next_page_url
      };
    },
    isValidEmail: function(email) {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    },
    isValidContact: function(contact) {
      let flag = true;
      let msgs = [];
      contact.invalidEmail = "";
      contact.invalidFirstName = "";
      contact.invalidLastName = "";
      if (!this.isValidEmail(contact.email)) {
        flag = false;
        contact.invalidEmail = "invalid";
      }
      if (!contact.firstName || contact.firstName.trim() == "") {
        flag = false;
        contact.invalidFirstName = "invalid";
      }
      if (!contact.lastName || contact.lastName.trim() == "") {
        flag = false;
        contact.invalidLastName = "invalid";
      }
      return flag;
    },
    showToast: function({ text }) {
      this.msg = text;
      this.showToastFlag = true;
      setTimeout(() => {
        this.showToastFlag = false;
      }, 5000);
    }
  },
  mounted: function() {
    this.createGroupsById();
    this.getContacts();
  }
};
</script>