# Entity Relationship Diagram (ERD)

## Database Schema (DBML)

```dbml
Table users {
  id bigint [pk, increment]
  name varchar
  email varchar [unique, not null]
  password varchar [not null]
  created_at timestamp
  updated_at timestamp
}

Table personal_access_tokens {
  id bigint [pk, increment]
  tokenable_type varchar
  tokenable_id bigint
  name varchar
  token varchar [unique]
  abilities text
  last_used_at timestamp
  expires_at timestamp
  created_at timestamp
  updated_at timestamp
}

Table heroes {
  id bigint [pk, increment]
  opendota_hero_id int [unique, not null]
  name varchar [not null]
  localized_name varchar [not null]
  primary_attr varchar
  attack_type varchar
  roles text
  image varchar
  icon varchar
  created_at timestamp
  updated_at timestamp
}

Table draft_plans {
  id bigint [pk, increment]
  user_id bigint [not null]
  title varchar [not null]
  patch_version varchar
  strategy_notes text
  created_at timestamp
  updated_at timestamp
}

Table draft_plan_bans {
  id bigint [pk, increment]
  draft_plan_id bigint [not null]
  hero_id bigint [not null]
  note text
  sort_order int [default: 0]
  created_at timestamp
  updated_at timestamp
}

Table draft_plan_preferred_picks {
  id bigint [pk, increment]
  draft_plan_id bigint [not null]
  hero_id bigint [not null]
  note text
  priority int
  sort_order int [default: 0]
  created_at timestamp
  updated_at timestamp
}

Table draft_plan_enemy_threats {
  id bigint [pk, increment]
  draft_plan_id bigint [not null]
  hero_id bigint [not null]
  note text
  threat_level int
  sort_order int [default: 0]
  created_at timestamp
  updated_at timestamp
}

Table draft_plan_item_timings {
  id bigint [pk, increment]
  draft_plan_id bigint [not null]
  minute_mark int
  item_name varchar [not null]
  note text
  sort_order int [default: 0]
  created_at timestamp
  updated_at timestamp
}

// Relationships
Ref: draft_plans.user_id > users.id
Ref: draft_plan_bans.draft_plan_id > draft_plans.id
Ref: draft_plan_bans.hero_id > heroes.id
Ref: draft_plan_preferred_picks.draft_plan_id > draft_plans.id
Ref: draft_plan_preferred_picks.hero_id > heroes.id
Ref: draft_plan_enemy_threats.draft_plan_id > draft_plans.id
Ref: draft_plan_enemy_threats.hero_id > heroes.id
Ref: draft_plan_item_timings.draft_plan_id > draft_plans.id
```

---

## Relationships & Logic

- **Direct Relationships:**
  - `User` hasMany `DraftPlan`
  - `DraftPlan` belongsTo `User`
  - `DraftPlan` hasMany `DraftPlanBan`
  - `DraftPlan` hasMany `DraftPlanPreferredPick`
  - `DraftPlan` hasMany `DraftPlanEnemyThreat`
  - `DraftPlan` hasMany `DraftPlanItemTiming`
- **Hero Links:**
  - All ban, pick, and threat entries belong to a `Hero`.
- **Cascade Deletion:**
  - All sub-entities are configured to **cascade delete** when the parent `DraftPlan` is removed from the database.
